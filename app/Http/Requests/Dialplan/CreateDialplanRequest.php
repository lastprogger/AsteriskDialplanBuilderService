<?php


namespace App\Http\Requests\Dialplan;


use App\Http\Requests\AbstractApiRequest;

class CreateDialplanRequest extends AbstractApiRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'company_id'                    => 'uuid',
            'pbx_scheme_id'                 => 'required|uuid',
            'pbx_id'                        => 'required|uuid',
            'nodes'                         => 'required|array',
            'nodes.*.id'                    => 'required|uuid',
            'nodes.*.node_type'             => 'required|array',
            'nodes.*.node_type.name'        => 'required|string',
            'nodes.*.node_type.type'        => 'required|string',
            'nodes.*.data'                  => 'required|array',
            'node_relations'                => 'required|array',
            'node_relations.*.type'         => 'required|string',
            'node_relations.*.from_node_id' => 'required|uuid',
            'node_relations.*.to_node_id'   => 'required|uuid',
        ];
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
    public function getPbxSchemeId(): string
    {
        return $this->get('pbx_scheme_id');
    }

    /**
     * @return string
     */
    public function getPbxId(): string
    {
        return $this->get('pbx_id');
    }
}