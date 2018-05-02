<?php
namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

Class VisitForm
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function vehicle()
    {
        return $this->entityManager->getRepository('App:vehicles')->findAll();
    }

    public  function status()
    {
        return $this->entityManager->getRepository('App:visitStatuses')->findAll();
    }

    public function service()
    {
        return $this->entityManager->getRepository('App:service')->findAll();
    }

    public function visit()
    {
        return $this->entityManager->getRepository('App:visits')->findAll();
    }

    public function choices($arr, $start)
    {
        $start = [0 => ['value' => '', 'name' => $start, 'attr' => 'disabled selected']];
        $temp = array_map(function ($e) {
            return ['value' => $e->getId(), 'name' => $e->getName()];
        }, $arr);
        $start = array_merge($start, $temp);
        return $start;
    }

    public static function form($method = 'get', $action = '')
    {
        return new class($method, $action)
        {
            public function __construct($method, $action)
            {
                $this->method = $method;
                $this->action = $action;
                $this->elements = [];
            }

            public function add($name, $type = 'text', $attr = '', $options = [], $required = true)
            {
                $temp['name'] = $name;
                $temp['type'] = $type;
                $temp['options'] = $options;
                $temp['required'] = $required;
                $this->elements[] = $temp;
            }

            public function generate()
            {
                $res = '<form action="' . $this->action . '" method="' . $this->method . '">';
                $res .= array_reduce($this->elements, function ($temp, $e) {
                    $string = '';
                    if (isset($e['options']['prefix'])) {
                        $string = $e['options']['prefix'];
                    }
                    if ($e['type'] != 'select') {
                        $e['options']['attr'] = isset($e['options']['attr']) ? $e['options']['attr'] : '';
                        if ($e['type'] == 'number') {
                            $e['options']['attr'] .= isset($e['options']['min']) ? (' min="' . $e['options']['min'] . '"') : '';
                            $e['options']['attr'] .= isset($e['options']['max']) ? (' max="' . $e['options']['max'] . '"') : '';
                        }
                        $e['options']['attr'] .= isset($e['options']['value']) ? (' value="' . $e['options']['value'] . '"') : '';
                        $string .= '<input name="' . $e['name'] . '" type="' . $e['type'] . '" ' . ($e['required'] ? 'required' : '')
                            . ' ' . $e['options']['attr'] . ' />';
                    } else {
                        $string .= '<select name="' . $e['name'] . '" ' . ($e['required'] ? 'required' : '') . '>';
                        $string .= array_reduce($e['options']['options'], function ($t, $a) use ($e) {
                            $a['attr'] = isset($a['attr']) ? $a['attr'] : '';
                            $select = (isset($e['options']['value']) && $e['options']['value'] == $a['value']) ? 'selected' : '';
                            return $t . '<option value="' . $a['value'] . '" ' . $a['attr'] . ' ' . $select . '>' . $a['name'] . '</option>';
                        }, '');
                        $string .= '</select>';
                    }
                    if (isset($e['options']['postfix'])) {
                        $string .= $e['options']['postfix'];
                    }
                    return $temp . $string;
                }, $res);
                return $res;
            }

            public function validate($req)
            {
                $res = true;
                foreach ($this->elements as $e) {
                    if ($e['required']) {
                        $post = $req->get($e['name'], null);
                        if ($e['type'] == 'number') {
                            if (isset($e['options']['min']) && $post < $e['options']['min']) {
                                return 'Per mažas skaičius ' . $e['name'] . ' laukelyje';
                            }
                            if (isset($e['options']['max']) && $post > $e['options']['max']) {
                                return 'Per didelis skaičius laukelyje <i>'.$e['name'].'</i>';
                            }
                        }
                        if ($e['type'] == 'select' && count(array_filter($e['options']['options'], function ($x) use ($post) {
                                return $x['value'] == $post;
                            })) != 1) {
                            return 'Blogas pasirinkimas sąraše <i>'.$e['name'].'</i>';
                        }
                    }
                }
                return $res;
            }
        };
    }
}