<?php

namespace Modules\Iplan\Repositories\Eloquent;

use Illuminate\Support\Arr;
use Modules\Iplan\Repositories\PlanRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Icommerce\Events\CreateProductable;
use Modules\Icommerce\Events\UpdateProductable;
use Modules\Icommerce\Events\DeleteProductable;

class EloquentPlanRepository extends EloquentBaseRepository implements PlanRepository
{

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['category','limits', 'product']);
    } else {//Especific relationships
      $includeDefault = ['category', 'limits'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
      $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      if(isset($filter->category)){
        $query->where('category_id',$filter->category);
      }//category

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
        $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
        $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
        ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
        ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
    $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }//getItemsBy()


  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['category', 'limits', 'product']);
    } else {//Especific relationships
      $includeDefault = ['category','limits'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
      $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Filter by specific field
      $field = $filter->field;
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
    $query->select($params->fields);

    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
  }//getItem()

  public function create($data)
  {
    $entity = $this->model->create($data);

    $entity->categories()->sync(array_merge(Arr::get($data, 'categories', []), [$entity->category_id])); //add multiple categories

    event(new UpdateProductable($entity, $data));
    event(new CreateMedia($entity,$data));
    return $entity;
  }//create()


  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
      $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    if($model){
      $model->update((array)$data);

      $model->categories()->sync(array_merge(Arr::get($data, 'categories', []), [$model->category_id])); //add multiple categories

      event(new UpdateProductable($model, $data));
      event(new UpdateMedia($model,$data));
      return $model;
    }

    return false;

  }//updateBy()

  public function deleteBy($criteria, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Where field
      $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    $model ? $model->delete() : false;
    event(new DeleteProductable($model));
    event(new DeleteMedia($model->id, get_class($model)));
  }//deleteBy()


}
