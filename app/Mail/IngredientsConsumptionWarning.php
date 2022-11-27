<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class IngredientsConsumptionWarning
 */
class IngredientsConsumptionWarning extends Mailable
{
    use Queueable, SerializesModels;

    public Ingredient $ingredient;

    /**
     * @param Ingredient $ingredient
     */
    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build(): IngredientsConsumptionWarning
    {
        return $this->subject(ucfirst($this->ingredient->name) . '\'s stock level has gone below 50% now.')
            ->view('emails.ingredients_consumption_warning');
    }
}
