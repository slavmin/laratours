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
    if (auth()->user()->can(config('access.teams.operator_permission'))) {
      return '<v-btn color="yellow" text icon small class="tc-link-no-underline-on-hover"
                href="' . route('frontend.tour.' . $this->model_alias . '.edit', $this) . '"
                title="' . __('labels.general.buttons.update') . '"
              >
                <v-icon>
                  edit
                </v-icon>
            </v-btn>';
    } elseif (auth()->user()->can(config('access.teams.agent_permission'))) {
      return '<v-btn color="yellow" text icon small class="tc-link-no-underline-on-hover"
                href="' . route('frontend.agency.' . $this->model_alias . '.edit', $this) . '"
                title="' . __('labels.general.buttons.update') . '"
              >
                <v-icon>
                  edit
                </v-icon>
            </v-btn>';
    }
  }

  /**
   * @return string
   */
  public function getDeleteButtonAttribute()
  {
    if (auth()->user()->can(config('access.teams.operator_permission'))) {
      return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.destroy', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <v-btn type="submit" text icon color="red" title="' . __('labels.general.buttons.delete') . '">
                  <v-icon>delete</v-icon>
                </v-btn>
                </form>';
    } elseif (auth()->user()->can(config('access.teams.agent_permission'))) {
      return '<form style="display: inline-block;" action="' . route('frontend.agency.' . $this->model_alias . '.destroy', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <v-btn type="submit" text icon color="red" title="' . __('labels.general.buttons.delete') . '">
                  <v-icon>delete</v-icon>
                </v-btn>
                </form>';
    }
  }


  /**
   * @return string
   */
  public function getDeletePermanentlyButtonAttribute()
  {
    if (auth()->user()->can(config('access.teams.operator_permission'))) {
      return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.delete-permanently', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-outline-danger" title="' . __('labels.general.buttons.delete-permanently') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
    } elseif (auth()->user()->can(config('access.teams.agent_permission'))) {
      return '<form style="display: inline-block;" action="' . route('frontend.agency.' . $this->model_alias . '.delete-permanently', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <button class="btn btn-outline-danger" title="' . __('labels.general.buttons.delete-permanently') . '"><i class="far fa-trash-alt"></i></button>
                </form>';
    }
  }

  /**
   * @return string
   */
  public function getRestoreButtonAttribute()
  {
    if (auth()->user()->can(config('access.teams.operator_permission'))) {
      return '<a href="' . route('frontend.tour.' . $this->model_alias . '.restore', $this) . '"
        class="btn btn-outline-success ml-1"><i class="fas fa-sync" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.restore') . '"></i></a>';
    } elseif (auth()->user()->can(config('access.teams.agent_permission'))) {
      return '<a href="' . route('frontend.agency.' . $this->model_alias . '.restore', $this) . '"
        class="btn btn-outline-success ml-1"><i class="fas fa-sync" data-toggle="tooltip" data-placement="top" title="' . __('labels.general.buttons.restore') . '"></i></a>';
    }
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
