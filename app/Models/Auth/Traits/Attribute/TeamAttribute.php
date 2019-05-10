<?php

namespace App\Models\Auth\Traits\Attribute;

/**
 * Trait TeamAttribute.
 */
trait TeamAttribute
{
    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.auth.team.show', $this) . '"
        data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '"
        class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.auth.team.edit', $this) . '"
        class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.auth.team.destroy', $this) . '"
			 data-method="delete"
			 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
			 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
			 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
			 class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.delete') . '"></i></a> ';
    }


    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="' . route('admin.auth.team.delete-permanently', $this) . '"
             data-method="delete"
             data-trans-button-cancel="' . __('buttons.general.cancel') . '"
			 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
			 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
             class="btn btn-danger"><i class="fas fa-trash"
             data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.access.teams.delete_permanently') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="' . route('admin.auth.team.restore', [$this]) . '"
        	 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
			 data-trans-button-confirm="' . __('buttons.general.crud.restore') . '"
			 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
             name="confirm_item" class="btn btn-info"><i class="fas fa-sync"
             data-toggle="tooltip" data-placement="top" title="' . __('buttons.backend.access.teams.restore_team') . '"></i></a> ';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '
				<div class="btn-group" role="group" aria-label="' . __('labels.backend.access.teams.team_actions') . '">
				  ' . $this->restore_button . '
				  ' . $this->delete_permanently_button . '
				</div>';
        }

        return '<div class="btn-group" role="group" aria-label="' . __('labels.backend.access.teams.team_actions') . '">
              ' . $this->show_button . '
			  ' . $this->edit_button . '
			  ' . $this->delete_button . '
			</div>';
    }
}
