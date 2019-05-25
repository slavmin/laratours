<?php

namespace App\Models\Tour\Traits\Attribute;


trait OrderButtonsAttribute
{
    /**
     * @return string
     */
    public function getCreateButtonAttribute()
    {
        return '<a href="' . route('frontend.tour.' . $this->model_alias . '.create', $this) . '"
        class="btn btn-success ml-1"><i class="fas fa-plus" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.create') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('frontend.tour.' . $this->model_alias . '.edit', $this) . '"
        class="btn btn-outline-success"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.update') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.destroy', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-outline-danger" title="' . __('labels.general.buttons.delete') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
    }


    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
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
        return '<a href="' . route('frontend.tour.' . $this->model_alias . '.restore', $this) . '"
        class="btn btn-outline-success ml-1"><i class="fas fa-sync" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.restore') . '"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="ml-1">
				  ' . $this->restore_button . '
				  ' . $this->delete_permanently_button . '
				</div>';
        }

        return '
            <div class="ml-1">
			  ' . $this->edit_button . '
			  ' . $this->delete_button . '
			</div>';
    }
}