<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'LOCATION';
    protected $primaryKey = 'LOC_ID';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     *  "LOC_ID" serial NOT NULL,
     *  "LOC_TITLE" character varying(100),         //  Location Title, Company Name
     *  "LOC_ADDRESS1" character varying(100),      //  Address Line 1
     *  "LOC_ADDRESS2" character varying(100),      //  Address Line 2
     *  "LOC_ADDRESS3" character varying(100),      //  Address Line 3
     *  "LOC_ADDRESS4" character varying(100),      //  Address Line 4
     *  "LOC_ADDRESS5" character varying(100),      //  Address Line 5
     *  "LOC_PHONE1" character varying(100),        //  Phone Number 1
     *  "LOC_PHONE2" character varying(100),        //  Phone Number 2
     *  "LOC_FAX1" character varying(100),          //  Fax Number 1
     *  "LOC_FAX2" character varying(100),          //  Fax Number 2
     *  "LOC_MOB1" character varying(100),          //  Mobile Number 1
     *  "LOC_MOB2" character varying(100),          //  Mobile Number 2
     *  "LOC_EMAIL1" character varying(100),        //  Email 1
     *  "LOC_EMAIL2" character varying(100),        //  Email 2
     *  "LOC_WEBSITE" character varying(100),       //  Website URL
     *  "LOC_HEADOFFICE" integer,                   //  Head Office Location ID
     *  "LOC_MAPLINK" character varying(1000),      //  Location Google Maps URL, for Head Offices only
     *  "LOC_HEADING" character varying(100),       //  Location Heading
     *  "LOC_ORDER" integer DEFAULT 0,              //  Ordering priority when there are multiple locations in a country
     *  CONSTRAINT "PK+LOC" PRIMARY KEY ("LOC_ID")
     *
     */
    protected $fillable = ['LOC_TITLE', 'LOC_ADDRESS1', 'LOC_ADDRESS2', 'LOC_ADDRESS3', 'LOC_ADDRESS4', 'LOC_ADDRESS5', 'LOC_PHONE1', 'LOC_PHONE2', 'LOC_FAX1', 'LOC_FAX2', 'LOC_MOB1', 'LOC_MOB2', 'LOC_EMAIL1', 'LOC_EMAIL2', 'LOC_WEBSITE', 'LOC_HEADOFFICE', 'LOC_MAPLINK', 'LOC_HEADING', 'LOC_ORDER'];

    public function Countries()
    {
        return $this->belongsToMany('App\Country', 'COULOC', 'COULOC_LOC_ID', 'COULOC_COU_ID');
    }
}
