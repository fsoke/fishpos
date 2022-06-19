<?php

namespace App\Observers;

use App\Product;
use App\StockAdjustmentLine;

class StockAdjustmentObserver
{
    public function saving(StockAdjustmentLine $stockAdjustment)
    {
        $trans_type = $stockAdjustment->transaction->adjustment_type;
        $product = Product::findorfail($stockAdjustment->product_id);
        if ($trans_type == 'normal') {
            $adjusted = $product->pieces + $stockAdjustment->pieces;
        } else {
            $adjusted = $product->pieces - $stockAdjustment->pieces;
        }
        $product->update(['pieces' => $adjusted]);
    }

    public function deleting(StockAdjustmentLine $stockAdjustment)
    {
        $trans_type = $stockAdjustment->transaction->adjustment_type;
        $product = Product::findorfail($stockAdjustment->product_id);
        if ($trans_type == 'normal') {
            $adjusted = $product->pieces - $stockAdjustment->pieces;
        } else {
            $adjusted = $product->pieces + $stockAdjustment->pieces;
        }
        $product->update(['pieces' => $adjusted]);
    }
}
