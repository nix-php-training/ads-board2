<?php

class Validator
{

    private $errorMessage = [
        'required' => ':attribute field is required',
        'integer' => ':attribute field must be an integer',
        'float' => ':attribute field must be a float',
        'numeric' => ':attribute field must be numeric',
        'email' => ':attribute is not a valid email',
        'ip' => ':attribute must contain a valid IP',
        'url' => ':attribute must contain a valid URL',
        'max_length' => ':attribute can be maximum :params character long',
        'min_length' => ':attribute must be minimum :params character long',
        'exact_length' => ':attribute field must :params character long',
        'login' => ':attribute can contain only letters, numbers, hyphens (-), and underscores (_)',
        'date' => ':attribute must be date in format YYYY-MM-DD'
    ];

    private function getErrorMessage($error, $attribute, $params = '')
    {
        $message = str_replace(':attribute', $attribute, $this->errorMessage[$error]);
        $message = str_replace(':params', $params, $message);
        return ucfirst($message);
    }

    private function getParams($rule)
    {
        if (preg_match("#^([a-zA-Z0-9_]+)\((.+?)\)$#", $rule, $matches)) {
            return array(
                'rule' => $matches[1],
                'params' => $matches[2],
            );
        }
        return array(
            'rule' => $rule,
            'params' => '',
        );
    }

    private function isRequired($data)
    {
        foreach ($data as $k) {
            if ($k == 'required') {
                return true;
            }
        }
        return false;
    }

    /**
     * example $input = ['name'=>'Boris', 'age'=>'25']
     * $rules = ['name'=>['required', 'min_length(3)'],'age'=>['numeric']];
     * @param array $inputs
     * @param array $rules
     * @return array
     */
    public function validate($inputs, $rules)
    {
        $errors = [];
        foreach ($rules as $input => $input_rules) {
            if (is_array($input_rules)) {
                foreach ($input_rules as $rule => $closure) {
                    if (!isset($inputs[(string)$input])) {
                        $input_value = null;
                    } else {
                        $input_value = $inputs[(string)$input];
                    }
                    if (!$input_value && $this->isRequired($rules[(string)$input])) {

                        if (!isset($errors[$input])) {
                            $errors[$input][] = $this->getErrorMessage('required', $input);
                        }
                    } else {
                        if (is_numeric($rule)) {
                            $rule = $closure;
                        }
                        $rule_and_params = $this->getParams($rule);
                        $params = $real_params = $rule_and_params['params'];
                        $rule = $rule_and_params['rule'];
                        $result = $this->validateOne($input_value, $rule, $params, $input);
                        if ($result !== true) {
                            $errors[$input][] = $result;
                        }
                    }
                }
            }
        }
        return $errors;
    }

    /**
     * @param string $data
     * @param string $method
     * @param string $params
     * @param string $name
     * @return bool|string
     */
    public function validateOne($data, $method, $params = '', $name = 'data')
    {
        if (method_exists($this, $method) && !empty($params)) {
            $result = $this->$method($data, $params);
        } elseif (method_exists($this, $method)) {
            $result = $this->$method($data);
        }
        if (empty($result)) {
            return $this->getErrorMessage($method, $name, $params);
        } else {
            return true;
        }
    }

    protected function required($input = null)
    {
        return (!is_null($input) && (trim($input) != ''));
    }

    protected function numeric($input)
    {
        return is_numeric($input);
    }

    protected function email($input)
    {
        return (filter_var($input, FILTER_VALIDATE_EMAIL)) == false ? false : true;
    }

    protected function integer($input)
    {
        return is_int($input) || ($input == (string)(int)$input);
    }

    protected function float($input)
    {
        return is_float($input) || ($input == (string)(float)$input);
    }

    protected function ip($input)
    {
        return filter_var($input, FILTER_VALIDATE_IP);
    }

    protected function url($input)
    {
        return filter_var($input, FILTER_VALIDATE_URL);
    }

    protected function max_length($input, $length)
    {
        return (strlen($input) <= $length);
    }

    protected function min_length($input, $length)
    {
        return (strlen($input) >= $length);
    }

    protected function exact_length($input, $length)
    {
        return (strlen($input) == $length);
    }

    protected function login($input)
    {
        return preg_match('/^[a-zA-Z0-9_-]+$/', $input);
    }

    protected function date($input)
    {
        return preg_match('/^[\d]{4}[-/][\d]{2}[-/][\d]{2}', $input);
    }


}