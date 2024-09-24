<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class DublicateAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Dublicate';
    }

    public function getIcon()
    {
        return 'voyager-bag';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-2',
        ];
    }

    public function getDefaultRoute()
    {
        // return route('voyager.products.duplicate',['product' => $this->data->id]);
        
    if ($this->dataType->slug == 'products') {
        return route('voyager.products.duplicate', ['product' => $this->data->id]);
    } elseif ($this->dataType->slug == 'product-customizations') {
       
        return route('voyager.products.duplicate3d', ['product' => $this->data->id]);
    }

    // Default route or error handling
    return route('voyager.dashboard');
    }
}