<?php

namespace App\Observers;

use App\Product;
use App\TransactionSellLine;

class TransactionSellObserver
{
    public function creating(TransactionSellLine $transactionSellLine)
    {
        $product = Product::find($transactionSellLine->product_id);
        $adjusted = $product->pieces - $transactionSellLine->pieces;
        $product->update(['pieces' => $adjusted]);
        $product->increment('total_pieces_sold',$transactionSellLine->pieces);
    }

    public function updating(TransactionSellLine $transactionSellLine)
    {
        $product = Product::find($transactionSellLine->product_id);

        if ($transactionSellLine->isDirty('pieces')) {
            $oldValue = $transactionSellLine->getOriginal('pieces');

            $adjusted = (($product->pieces - $oldValue) + $transactionSellLine->pieces);
            $product->update(['pieces' => $adjusted]);
        }
    }
}
