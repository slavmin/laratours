<?php

namespace App\Models\Tour\Traits\Attribute;


trait ActionButtonsAttribute
{
    public function getCityListButtonAttribute()
    {
        return '<a href="' . route('frontend.tour.city.index', [$this]) . '" 
        class="btn btn-outline-info" data-toggle="tooltip" title="' . __('buttons.tours.city_list') . '">
                                                <i class="fas fa-list-alt"></i></a>';
    }

    public function getCreateOrderButtonAttribute()
    {
        return '<a href="' . route('frontend.agency.order.create', $this) . '"
        class="btn btn-success ml-1"><i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.reserve') . '"></i></a>';
    }

    public function getCreateButtonAttribute()
    {
        if ($this->model_alias == 'city') {
            return '<a href="' . route('frontend.tour.' . $this->model_alias . '.create', [$this->country_id, $this]) . '"
        class="btn btn-success ml-1"><i class="fas fa-plus" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.create') . '"></i></a>';
        }

        return '<a href="' . route('frontend.tour.' . $this->model_alias . '.create', $this) . '"
        class="btn btn-success ml-1"><i class="fas fa-plus" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.create') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        if ($this->model_alias == 'city') {
            return '<a href="' . route('frontend.tour.' . $this->model_alias . '.edit', [$this->country_id, $this]) . '"
        class="btn btn-yellow btn-small"><i class="fas fa-pen" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.update') . '"></i></a>';
        }

        return '<a href="' . route('frontend.tour.' . $this->model_alias . '.edit', $this) . '"
        class="btn btn-yellow btn-small"><i class="fas fa-pen" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.update') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        if ($this->model_alias == 'city') {

            return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.destroy', [$this->country_id, $this]) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-danger" title="' . __('labels.general.buttons.delete') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
        }

        return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.destroy', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-danger" title="' . __('labels.general.buttons.delete') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
    }


    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        if ($this->model_alias == 'city') {

            return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.delete-permanently', [$this->country_id, $this]) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-outline-danger" title="' . __('labels.general.buttons.delete-permanently') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
        }

        return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.delete-permanently', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-outline-danger" title="' . __('labels.general.buttons.delete-permanently') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        if ($this->model_alias == 'city') {
            return '<a href="' . route('frontend.tour.' . $this->model_alias . '.restore', [$this->country_id, $this]) . '"
        class="btn btn-outline-success ml-1"><i class="fas fa-sync" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.restore') . '"></i></a>';
        }
        return '<a href="' . route('frontend.tour.' . $this->model_alias . '.restore', $this) . '"
        class="btn btn-outline-success ml-1"><i class="fas fa-sync" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.restore') . '"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if (auth()->user()->can(config('access.teams.operator_permission'))) {
            if ($this->trashed()) {
                return '
				<div class="ml-1">
				  ' . $this->restore_button . '
				  ' . $this->delete_permanently_button . '
				</div>';
            }

            if ($this->model_alias == 'country') {
                return '
            <div class="ml-1">
              ' . $this->city_list_button . '
			  ' . $this->edit_button . '
			  ' . $this->delete_button . '
			</div>';
            }

            return '
            <div class="ml-1">
			  ' . $this->edit_button . '
			  ' . $this->delete_button . '
			</div>';
        } elseif (auth()->user()->can(config('access.teams.agent_permission'))) {
            return '
            <div class="ml-1">
              ' . $this->create_order_button . '
			</div>';
        }
    }
}
