<?php


namespace App\Http\Requests\SipUser;


use App\Http\Requests\AbstractApiRequest;

class CreateSipUserRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'number'          => 'required|integer',
            'company_id'      => 'required|uuid',
            'call_scope'      => 'required|integer',
            'caller_name'     => 'string',
            'phone_number_id' => 'required|uuid',
        ];
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->get('number');
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->get('company_id');
    }

    /**
     * @return string
     */
    public function getCallScope(): string
    {
        return $this->get('call_scope');
    }

    /**
     * @return string|null
     */
    public function getCallerName(): ?string
    {
        return $this->get('caller_name');
    }

    /**
     * @return string
     */
    public function getPhoneNumberId(): string
    {
        return $this->get('phone_number_id');
    }
}