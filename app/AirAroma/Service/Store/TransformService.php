<?php

namespace AirAroma\Service\Store;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TransformService
{
    /**
     * Transform database results into organised json string
     *  
     * @return Fractal
     */
    public function transformResults($results, $transformer, $includes = null)
    {
        $this->transformer = $transformer;

        $this->fractal = fractal();

        $this->fractal->parseIncludes($includes);

        if (isset($this->paginate)) {
            $pagination = $results->paginate($this->paginate);
            $this->data = $pagination->getCollection();
            $this->fractal->paginateWith(new IlluminatePaginatorAdapter($pagination));
        } else {
            $this->data = $results;
        }

        return $this;
    }

    public function collection() {
        $this->fractal->collection($this->data->get(), $this->transformer);
        return $this->fractal->toArray();
    }

    public function item() {
        $this->fractal->item($this->data->first(), $this->transformer);
        return $this->fractal->toArray();
    }

    public function relation() {
        $this->fractal->collection($this->data, $this->transformer);
        return $this->fractal->toArray();
    }

    public function setPaginate($paginate) {
        $this->paginate = $paginate;
    }
}