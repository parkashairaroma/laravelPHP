<?php

namespace AirAroma\Repository;
use Illuminate\Contracts\Auth\Guard;
use AirAroma\Model\Email;
use AirAroma\Model\EmailType;

class EmailRepository
{
    function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * get emails list
     */
    public function getEmailsList()
    {
        return $this->email->where('eml_ety_id', '=', 8)->orWhere('eml_ety_id', '=', 9)->orWhere('eml_ety_id', '=', 10)->orWhere('eml_ety_id', '=', 11)
               ->join('emailtypes', 'emailtypes.ety_id', '=', 'emails.eml_ety_id')
               ->leftjoin('regions', 'regions.reg_id', '=', 'emails.eml_reg_id')->get();
    }

    /**
     * update emails list
     */
    public function updateEmailList($emailtype, $region ,$emails)
    {
        return $this->email->where('eml_ety_id', $emailtype)->where('eml_reg_id', $region)->update(['eml_address' => $emails]);
    }


}
