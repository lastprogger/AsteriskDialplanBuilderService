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
            'company_id'                    => 'int',
            'pbx_scheme_id'                 => 'required|array',
            'nodes'                         => 'required|array',
            'nodes.*.id'                    => 'required|string',
            'nodes.*.node_type'             => 'required|array',
            'nodes.*.node_type.name'        => 'required|array',
            'nodes.*.node_type.type'        => 'required|array',
            'nodes.*.data'                  => 'required|array',
            'node_relations'                => 'required|array',
            'node_relations.*.type'         => 'required|string',
            'node_relations.*.from_node_id' => 'required|string',
            'node_relations.*.to_node_id'   => 'required|string',

        ];
    }
}