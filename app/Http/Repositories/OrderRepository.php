<?php

namespace App\Http\Repositories;

use App\Mail\IngredientsConsumptionWarning;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    /**
     * @var Order $order
     */
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param array $payload
     * @return Builder|Model|null
     */
    public function create(array $payload): null|Builder|Model
    {
        $order = $this->order->create([]);

        foreach ($payload['products'] as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);

            $this->updateIngredientsStock($product);
        }

        return $this->order->with('products.ingredients')->where('id', $order->id)->first();
    }

    /**
     * @param array $product
     * @return void
     */
    public function updateIngredientsStock(array $product): void
    {
        $ingredients = DB::table('product_ingredients')
            ->join('ingredients', 'product_ingredients.ingredient_id', '=', 'ingredients.id')
            ->where('product_id', $product['product_id'])
            ->select(['product_ingredients.ingredient_id', 'product_ingredients.quantity', 'ingredients.amount_consumed'])
            ->get();

        foreach ($ingredients as $ingredient) {
            $amountConsumed = $ingredient->quantity * $product['quantity'] + $ingredient->amount_consumed;
            //update and return ingredient
            $updatedIngredient = tap(Ingredient::where('id', $ingredient->ingredient_id))->update([
                'amount_consumed' => $amountConsumed
            ])->first();

            if (($amountConsumed / $updatedIngredient->total_amount * 100 >= 50) && !$updatedIngredient->consumption_warning_sent) {
                //send warning email about this ingredient's consumption
                \Mail::to('sohail.ahmad11121@gmail.com')->send(new IngredientsConsumptionWarning($updatedIngredient));
            }
        }
    }
}
