<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'       => 'required|string|unique:games,title',
            'description' => '',
            'complexity'  => 'required|min:1|max:10',
            'minPlayers'  => 'required|min:1|max:10',
            'maxPlayers'  => 'required|min:1|max:10',
            'isActive'    => 'required|boolean'
        ];
        dd($this->getMethod());
        switch ($this->getMethod()) {
            case 'POST':
                return $rules;
            case 'PUT':
                return [
                        'game_id' => 'require|integer|exists:games,id',
                        //должен существовать. Можно вот так: unique:games,id,' . $this->route('game'),
                        'title'   => [
                            'required',
                            Rule::unique('games')->ignore($this->title, 'title')
                            //должен быть уникальным, за исключением себя же

                        ],
                    ] + $rules; // и берем все остальные правила
            // case 'PATCH'
            case 'DELETE':
                return [
                    'game_id' => 'required|integer|exists:games,id'
                ];
        }
    }

    public function messages()
    {
        return [
            'date.required' => 'A date is required',
            'date.date_format'  => 'A date must be in format: Y-m-d',
            'date.unique'  => 'This date is already taken',
            'date.after_or_equal'  => 'A date must be after or equal today',
            'date.exists'  => 'This date doesn\'t exists',
        ];
    }

    public function all()
    {
//        return $this->all();

        /** @var FormRequest $keys */
        $data = parent::all($keys);
        switch ($this->getMethod())
        {
            // case 'PUT':
            // case 'PATCH':
            case 'DELETE':
                $data['date'] = $this->route('day');
        }
        return $data;
    }
}
