<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProductsShowVoltTest extends TestCase
{
    use RefreshDatabase;

    private function makeProductWithVariants(): Product
    {
        $product = Product::create([
            'name' => 'Test Shirt',
            'description' => 'A testable product',
            'category' => 'Apparel',
            'min_variant_price' => null,
        ]);

        // Available, in-stock variants
        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'TS-BLK-M',
            'size' => 'M',
            'color' => 'Black',
            'price' => 29.99,
            'stock' => 5,
            'is_available' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'TS-WHT-S',
            'size' => 'S',
            'color' => 'White',
            'price' => 27.99,
            'stock' => 3,
            'is_available' => true,
        ]);

        // Size L exists but NOT purchasable (stock 0)
        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'TS-WHT-L',
            'size' => 'L',
            'color' => 'White',
            'price' => 31.99,
            'stock' => 0,
            'is_available' => true,
        ]);

        // Another color/size that is unavailable
        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'TS-BLK-S',
            'size' => 'S',
            'color' => 'Black',
            'price' => 27.99,
            'stock' => 10,
            'is_available' => false,
        ]);

        return $product->fresh(['variants']);
    }

    public function test_initial_render_shows_all_sizes_and_colors(): void
    {
        $product = $this->makeProductWithVariants();

        $component = Volt::test('products.show', ['id' => $product->id]);

        $html = $component->html();

        // Check that Alpine.js data contains all colors and sizes
        $this->assertStringContainsString('Black', $html);
        $this->assertStringContainsString('White', $html);
        $this->assertStringContainsString('isColorDisabled', $html);
        $this->assertStringContainsString('isSizeDisabled', $html);
        $this->assertStringContainsString('toggleColor', $html);
        $this->assertStringContainsString('toggleSize', $html);
    }

    public function test_component_renders_product_details(): void
    {
        $product = $this->makeProductWithVariants();

        Volt::test('products.show', ['id' => $product->id])
            ->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee($product->category);
    }

    public function test_component_loads_variants_into_alpine_data(): void
    {
        $product = $this->makeProductWithVariants();

        $html = Volt::test('products.show', ['id' => $product->id])->html();

        // Verify variants are passed to Alpine.js (HTML entities in rendered output)
        $this->assertStringContainsString('variants:', $html);
        $this->assertStringContainsString('&quot;color&quot;:&quot;Black&quot;', $html);
        $this->assertStringContainsString('&quot;color&quot;:&quot;White&quot;', $html);
        $this->assertStringContainsString('&quot;size&quot;:&quot;M&quot;', $html);
        $this->assertStringContainsString('&quot;size&quot;:&quot;S&quot;', $html);
        $this->assertStringContainsString('&quot;size&quot;:&quot;L&quot;', $html);
        $this->assertStringContainsString('&quot;price&quot;:&quot;29.99&quot;', $html);
        $this->assertStringContainsString('&quot;price&quot;:&quot;27.99&quot;', $html);
    }
}
