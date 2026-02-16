# Subscription Service Spec (MVP v2)

## 1. Objective
Build a clothing subscription MVP with 3 tiers, Stripe-powered billing, a public pricing landing page, and an authenticated subscription management page.

## 2. Subscription Tiers
1. `baseline_monthly`
- Includes: 1 baseline shirt per billing cycle. At 25$

2. `premium_monthly`
- Includes: 2 premium shirts per billing cycle. At 40$

3. `mixed_monthly`
- Includes: 1 baseline shirt + 1 ultra premium shirt per billing cycle. At $50

Notes:
- Each tier maps to a Stripe Product + recurring Price.
- Copy and naming in UI should be business-friendly; internal IDs remain stable.

## 3. User-Facing Pages

### 3.1 Public landing page (`/subscriptions`)
- Shows 3 plans with:
  - Plan name
  - Monthly price
  - Included shirt allocation
  - CTA (`Subscribe` / `Current plan` if logged in and active)
- Includes FAQ snippet (billing cadence, cancellation timing, swaps/upgrades).

### 3.2 Manage subscription page (`/account/subscription`)
Authenticated page where customer can:
- View current plan and status (`active`, `trialing`, `past_due`, `canceled`, `incomplete`, `unpaid`).
- Upgrade/downgrade between the 3 tiers.
- Cancel subscription immediately.
- View next invoice date and amount (if available via Stripe).

## 4. Billing & Stripe Integration

## 4.1 Recommended approach
Use Laravel Cashier (Stripe) for subscription lifecycle operations.
- Why: native Laravel model integration, webhook handling, subscription status helpers, proration handling support.

## 4.2 Authentication
Use Laravel Breeze (Blade + Tailwind) for authentication scaffolding.
- Provides: login, register, password reset, email verification.
- Matches existing Blade + Tailwind frontend stack.
- Checkout creates account: guests are redirected through Stripe Checkout, and a user account is created on `checkout.session.completed` webhook using the Stripe customer email. A welcome email with a password-set link is sent post-creation.

## 4.3 Stripe objects
- Product: one per tier.
- Price: monthly recurring price per product.
- Customer: one per app user.
- Subscription: one active subscription per user (MVP assumption).

## 4.4 Webhooks (required)
Handle and persist key events:
- `checkout.session.completed`
- `customer.subscription.created`
- `customer.subscription.updated`
- `customer.subscription.deleted`
- `invoice.payment_succeeded`
- `invoice.payment_failed`
- `customer.subscription.trial_will_end`

## 4.5 Upgrade/downgrade behavior
- Decision: prorate immediately (`swapAndInvoice`) for upgrades and downgrades.

## 4.6 Cancellation behavior
- Decision: immediate cancellation (`cancelNow`).
- Refund handling: no automatic prorated refund in MVP unless manually handled by support.

## 4.7 Free trial
- 14-day free trial on all tiers.
- Trial starts on subscription creation; no payment charged until trial ends.
- User must provide payment method upfront (Stripe Checkout collects it).
- If user cancels during trial, no charge occurs.

## 4.8 Checkout flow details
- Stripe Checkout Session with `mode: 'subscription'` and `trial_period_days: 14`.
- `success_url`: `/account/subscription?checkout=success`
- `cancel_url`: `/subscriptions?checkout=canceled`
- Checkout does not require prior authentication — account is created post-checkout.

## 4.9 Payment method management
- Custom in-app UI on `/account/subscription` for updating payment method.
- Use Cashier's `updatePaymentMethod()` with Stripe Elements / Setup Intent.
- No Stripe Billing Portal in MVP.

## 4.10 Webhook idempotency
- Store processed Stripe event IDs to prevent duplicate handling.
- All webhook handlers check for existing event ID before processing.

## 4.11 Environment configuration
Required env vars:
- `STRIPE_KEY` (publishable key)
- `STRIPE_SECRET` (secret key)
- `STRIPE_WEBHOOK_SECRET` (webhook signing secret)
- Use Stripe test mode keys during development; switch to live keys for production.

## 5. Application Data Model

## 5.1 Existing user table updates
Add Stripe fields to `users`:
- `stripe_id`
- `pm_type`
- `pm_last_four`
- `trial_ends_at`

## 5.2 Cashier tables
Install migrations for:
- `subscriptions`
- `subscription_items`

## 5.3 Domain extension (fulfillment tracking)
Add internal table for cycle entitlements/orders (name tentative: `subscription_allocations`):
- `user_id`
- `subscription_tier`
- `period_start`
- `period_end`
- `baseline_qty`
- `premium_qty`
- `ultra_premium_qty`
- `fulfilled_at` (nullable)

This decouples fulfillment from Stripe billing objects.

## 5.4 Fulfillment model
- Decision: curated shipment only (no shirt selection UI in MVP).
- Allocation is generated from plan tier and billing cycle.

## 5.5 Allocation trigger
- A `subscription_allocations` row is created when `invoice.payment_succeeded` webhook fires.
- The invoice's `period_start` and `period_end` map to the allocation period.
- Quantities are derived from the subscription tier at time of payment.
- Trial-period invoices ($0) also trigger an allocation so trial users receive shirts.
- Unique constraint on (`user_id`, `period_start`, `period_end`) prevents duplicates.

## 6. Core Flows

## 6.1 Start subscription (guest)
1. User chooses plan on `/subscriptions`.
2. App creates Stripe Checkout Session (`mode: 'subscription'`, `trial_period_days: 14`).
3. Stripe collects email and payment method.
4. On `checkout.session.completed` webhook:
   a. If no user exists with that email, create user account (random password).
   b. Link Stripe customer ID to user.
   c. Send welcome email with password-set link.
5. User redirected to `success_url` → `/account/subscription?checkout=success`.

## 6.1b Start subscription (logged-in user)
1. User chooses plan on `/subscriptions`.
2. App creates Stripe Checkout Session pre-filled with user's email and existing Stripe customer ID (if any).
3. On webhook, subscription is linked to existing user.
4. User redirected to `/account/subscription`.

## 6.2 Upgrade/downgrade
1. User chooses new plan in management page.
2. App performs plan swap in Stripe.
3. UI reflects updated tier and proration outcome.

## 6.3 Cancel
1. User clicks cancel.
2. App cancels immediately in Stripe.
3. Access to subscription benefits ends immediately.

## 6.4 Payment failure (dunning)
1. `invoice.payment_failed` webhook fires.
2. Subscription status moves to `past_due`.
3. User receives plain-text email: "Your payment failed. Please update your payment method."
4. `/account/subscription` shows a banner with payment update CTA.
5. Stripe retries per its Smart Retries schedule. If all retries fail, subscription moves to `canceled`.

## 6.5 Email notifications (plain text, MVP)
- **Welcome + set password**: sent when checkout creates a new account.
- **Subscription confirmed**: sent on `customer.subscription.created`.
- **Payment failed**: sent on `invoice.payment_failed`.
- **Subscription canceled**: sent on `customer.subscription.deleted`.
- **Trial ending soon**: sent 3 days before trial ends (Stripe can trigger `customer.subscription.trial_will_end`).

All emails are simple Laravel Mailables with plain-text templates. No HTML design in MVP.

## 7. Access Control & Security
- Management endpoints require auth.
- Verify webhook signatures using Stripe signing secret.
- Never trust client price IDs without server-side allowlist validation.
- Idempotency keys for write calls to Stripe (create checkout, swap, cancel).

## 8. Operations & Reliability
- Queue webhook processing.
- Add retries/dead-letter strategy for failed webhooks.
- Log subscription state transitions for audit/debugging.
- Add admin visibility in Nova for current plan/status and last billing event.
- Add Nova resources for `Subscription` and `SubscriptionAllocation`.
- Display subscription status and tier on User Nova resource.

## 9. Analytics (MVP)
Track:
- Checkout started/completed
- Conversion by plan
- Churn (canceled subscriptions)
- Upgrade/downgrade events
- Immediate cancellations

## 10. Testing Strategy
- Feature tests for:
  - Checkout initiation
  - Protected management page
  - Upgrade/downgrade/cancel endpoints
- Webhook tests with Stripe payload fixtures and signature validation.
- Happy path + failure path (`payment_failed`, `past_due`).

## 11. Non-Goals (MVP)
- Multi-subscription per user.
- Annual billing.
- Complex add-ons and coupons.
- Warehouse/logistics implementation beyond entitlement records.
- Customer-driven per-cycle product selection.

## 12. What You Were Missing (High Impact)
- Stripe webhook architecture and signature verification.
- Plan-to-fulfillment mapping separate from billing objects.
- Dunning/payment failure UX (`past_due` flow).
- US-only tax configuration and compliance policy.
- Trial policy and promo/coupon policy.
- Terms/refund policy around immediate cancellation.

## 13. Open Questions (Remaining)
1. Billing cadence: monthly only confirmed. Do you want annual plans later?
2. Inventory constraints: what happens if premium/ultra premium stock is out?

## 14. Confirmed Product Decisions
1. Upgrade/downgrade behavior: immediate proration.
2. Cancellation behavior: immediate cancellation.
3. Subscription management UX: in-app controls only (custom UI, no Stripe Billing Portal).
4. Fulfillment model: curated shipment by tier.
5. Pricing model: tax + shipping included in plan price.
6. Launch scope: United States only.
7. Authentication: Laravel Breeze (Blade + Tailwind).
8. Account creation: checkout creates account; no prior registration required.
9. Allocation trigger: `invoice.payment_succeeded` webhook.
10. Free trial: 14-day trial on all tiers, payment method collected upfront.
11. Emails: plain-text Laravel Mailables for MVP (welcome, confirmed, failed, canceled, trial ending).

## 15. Proposed Implementation Order
1. [x] Install Laravel Breeze (Blade + Tailwind) and configure auth scaffolding.
2. Install and configure Cashier + Stripe env vars.
3. Run Cashier migrations + add Stripe fields to users table.
4. Create Stripe products/prices (test mode) and map them in `config/subscriptions.php`.
5. Build `/subscriptions` public landing page + Stripe Checkout flow (guest + logged-in).
6. Build webhook controller: account creation, subscription sync, allocation creation.
7. Build `/account/subscription` management page: view plan, upgrade/downgrade, cancel, update payment method.
8. Add `subscription_allocations` model/migration and allocation logic on `invoice.payment_succeeded`.
9. Add plain-text email notifications (welcome, confirmed, failed, canceled, trial ending).
10. Add Nova resources for Subscription and SubscriptionAllocation.
11. Add feature tests and webhook tests.
12. Observability: log subscription state transitions.
