<?php

namespace Capmega\Base\Models\Generator;

use Capmega\Base\Models\ResourceModel;

class Crud extends ResourceModel
{
    private $template;
    public $model;
    public $new_model;
    public $name_space;
    public $location_path;
    public $view;
    public $view_path;
    public $route;
    public $route_path;
    public $translate;
    public $translate_path;
    public $nameSpace;
    public $translate_items;
    public $translate_file;
    public $key;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'model'          => 'required',
            'name_space'     => 'required',
            'location_path'  => 'required',
            'view'           => 'required',
            'view_path'      => 'required',
            'route'          => 'required',
            'route_path'     => 'required',
            'translate'      => 'required',
            'translate_path' => 'required',
            'resource'       => 'required',
        ];
    }

    /**
     * Get client attributes values.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'model'          => __('base::generator.model'),
            'name_space'     => __('base::generator.name_space'),
            'location_path'  => __('base::generator.location_path'),
            'view'           => __('base::generator.view'),
            'view_path'      => __('base::generator.view_path'),
            'route'          => __('base::generator.route'),
            'resource'       => __('base::generator.resource'),
            'route_path'     => __('base::generator.route_path'),
            'translate'      => __('base::generator.translate'),
            'translate_path' => __('base::generator.translate_path'),
            'key'            => __('base::generator.key'),
        ];
    }

    public function generate($template)
    {

        if (!class_exists($this->model, true)) {
            throw new \Exception("Class not exist", 1);
        }

        $this->new_model = new $this->model();
        $this->template = $template;
        $name_space = explode('\\', $this->name_space);
        $this->nameSpace = end($name_space);

        /**
         * Generate controller
         */
        $this->getFile([
            'sourcer' => 'Controller',
            'destiny' => $this->location_path.$this->nameSpace.'.php',
        ]);

        /**
         * Generate route
         */
        $this->getFile([
            'sourcer' => 'Route',
            'destiny' => $this->route_path.'.php',
            'append'  => true,
        ]);

        /**
         * Generate views
         */
        $this->getFile([
            'sourcer' => 'views/_form',
            'destiny' => $this->view_path.$this->view.'/_form.blade.php',
        ]);
        $this->getFile([
            'sourcer' => 'views/create',
            'destiny' => $this->view_path.$this->view.'/create.blade.php',
        ]);
        $this->getFile([
            'sourcer' => 'views/edit',
            'destiny' => $this->view_path.$this->view.'/edit.blade.php',
        ]);
        $this->getFile([
            'sourcer' => 'views/index',
            'destiny' => $this->view_path.$this->view.'/index.blade.php',
        ]);
        $this->getFile([
            'sourcer' => 'views/show',
            'destiny' => $this->view_path.$this->view.'/show.blade.php',
        ]);

        /**
         * Generate translate
         */
         $this->getFile([
             'sourcer' => 'Translate',
             'destiny' => $this->translate_path.'/es/'.$this->getTranslateFolder().'.php',
             'append'  => true,
         ]);
    }

    private function getTranslateFolder()
    {
        $folder = $this->translate;

        if (strpos($folder, ':') !== false) {
            $folder = explode(':', $folder)[1];
        }

        $folder = explode('.', $folder);
        $this->translate_file = $folder[0];
        $this->translate_items = $folder[1];
        return $this->translate_file;
    }

    private function getFile($params){
        extract($params);
        $folder = explode('/', $destiny);
        array_pop($folder);
        $folder = implode('/', $folder);

        if (!is_dir($folder)) {
            mkdir($folder);
        }

        ob_start();
        require($this->template.$sourcer.'.php');
        $content = ob_get_clean();
        if ($append??false) {
            file_put_contents($destiny, $content, FILE_APPEND);
        }else{
            file_put_contents($destiny, $content);
        }
    }
}
