<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use Illuminate\Support\Collection;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;
use Laravel\Passport\HasApiTokens;

/**
 * Class User.
 */
class User extends BaseUser implements HasMedia
{
    use UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        HasMediaTrait,
        UserHasTeams,
        HasApiTokens;


    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatars')->singleFile();
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('avatar')
            ->crop(Manipulations::CROP_TOP, 80, 80);
            //->nonQueued();

        $this->addMediaConversion('portrait')
            ->fit(Manipulations::FIT_FILL, 480, 480)
            ->background('ffffff');
            //->nonQueued();
    }

}
