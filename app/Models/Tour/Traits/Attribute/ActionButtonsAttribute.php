<?php

namespace App\Models\Tour\Traits\Attribute;


trait ActionButtonsAttribute
{
  public function getCityListButtonAttribute()
  {
    return '<v-btn text icon color="green" class="tc-link-no-underline-on-hover" href="' . route('frontend.tour.city.index', [$this]) . '">
          <v-icon title="' . __('buttons.tours.city_list') . '">
            list
          </v-icon>
        </v-btn>';
  }

  public function getCreateOrderButtonAttribute()
  {
    return '<v-btn color="#aa282a" small dark 
              href="' . route('frontend.agency.order.create', $this) . '"
              title="' . __('labels.general.buttons.reserve') . '">
              ' . __('labels.general.buttons.reserve') . '
            </v-btn>';
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
      return '<v-btn text icon color="green" class="tc-link-no-underline-on-hover" href="' . route('frontend.tour.' . $this->model_alias . '.edit', [$this->country_id, $this]) . '">
                <v-icon title="' . __('labels.general.buttons.update') . '">
                  edit
                </v-icon>
              </v-btn>';
    }

    return '<v-btn text icon color="green" class="tc-link-no-underline-on-hover" href="' . route('frontend.tour.' . $this->model_alias . '.edit', $this) . '">
              <v-icon title="' . __('labels.general.buttons.update') . '">
                edit
              </v-icon>
            </v-btn>';
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
                <v-btn type="submit" text icon color="red" title="' . __('labels.general.buttons.delete') . '">
                  <v-icon>delete</v-icon>
                </v-btn>
                </form>';
    }

    return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.destroy', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="DELETE"/>
                <v-btn type="submit" text icon color="red" title="' . __('labels.general.buttons.delete') . '">
                  <v-icon>delete</v-icon>
                </v-btn>
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
  public function getTogglePublishedButtonAttribute()
  {
    if (!$this->published) {
      return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.update', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="PATCH"/>
                <input type="hidden" name="toggle_published" value="1"/>
                <v-btn type="submit" text icon color="green darken-2" title="' . __('labels.general.buttons.publish') . '">
                  <v-icon>publish</v-icon>
                </v-btn>
            </form>';
    } else {
      return '<form style="display: inline-block;" action="' . route('frontend.tour.' . $this->model_alias . '.update', $this) . '" method="post">
                ' . csrf_field() . '
                <input type="hidden" name="_method" value="PATCH"/>
                <input type="hidden" name="toggle_published" value="1"/>
                <v-btn type="submit" text icon color="yellow darken-2" title="' . __('labels.general.buttons.unpublish') . '">
                  <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M9,4H15V12H19.84L12,19.84L4.16,12H9V4Z" />
                  </svg>
                </v-btn>
            </form>';
    }
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

      if ($this->model_alias == 'tour') {
        return '
            <div class="ml-1">
              ' . $this->toggle_published_button . '
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
