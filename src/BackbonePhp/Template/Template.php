<?php

namespace BackbonePhp\Template;

use BackbonePhp\Config\Config;

/**
 * BackbonePHP Template Class
 */
class Template
{

    /**
     * @var Config Configuration object  
     */
    protected $config;
    
    /**
     * @var string Template content
     */
    protected $content = '';
    
    /**
     * @var stdObject Template variables
     */
    protected $data = null;
    
    /**
     * Instantiates the template
     * 
     * @param Config $config Configuration object
     */
    public function __construct(Config $config = null, $data = null)
    {
        $this->config = $config ?: new Config();
        $this->data = $data ?: $this->getDefaultData();
    }
    
    /**
     * Creates a data object with default template variables
     */
    protected function getDefaultData()
    {
        $result = (object)[];
        foreach ($this->config->get('templateFields', []) as $field) {
            $result->$field = $this->config->get($field, '');
        }
        return $result;
    }
    
    /**
     * Sets the template's (main) content
     * 
     * @param string $content Template content
     * @return Template Template instance
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Returns the template's current content
     * 
     * @return string Template content
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Sets a template variable
     * 
     * @param string $name Variable name
     * @param mixed $value Variable value
     * @return Template Template instance
     */
    public function set($name, $value)
    {
        $this->data->$name = $value;
        return $this;
    }

    /**
     * Replaces template placeholders with variable values and sub-template content (recursively)
     * 
     * @param int $maxIterations Maximum number of recursions for nested variables and templates
     * @param int $iteration Current iteration
     * @return Template Template instance
     */
    public function render($maxIterations = 32, $iteration = 0)
    {
        if (strpos($this->content, '{') !== false) {
            $oldContent = $this->content;
            $this->renderVariables();
            $this->renderSubTemplates();
            $changed = $oldContent !== $this->content;
            if ($changed && $iteration < $maxIterations) { // allow up to $maxIterations recursions for nested variables and templates
                return $this->render($maxIterations, $iteration + 1);
            }
        }
        return $this;
    }
    
    /**
     * Replaces template placeholders with variable values (non-recursively)
     * 
     * Format: {varName}
     * 
     * @return Template Template instance
     */
    protected function renderVariables()
    {
        foreach ($this->data as $name => $value) {
            if (!is_string($value) && !is_numeric($value)) {
                $value = json_encode($value, JSON_PRETTY_PRINT && JSON_FORCE_OBJECT);
            }
            $this->content = str_replace("{{$name}}", $value, $this->content);
        }
        return $this;
    }
    
    /**
     * Replaces template placeholders with sub-template content (non-recursively)
     * 
     * Injects a "notFound" message when the template does not exist or is read-protected
     * 
     * Format: {/path/to/sub-template.tpl}
     * 
     * @return Template Template instance
     */
    protected function renderSubTemplates()
    {
        $this->content = preg_replace_callback('/\{(\/[^\}]+\.tpl)\}/', function($matches) {
            $subTemplatePath = $matches[1];
            // the path may be relative, try as-is first, then app path, then BackbonePHP path
            $paths = [
                $subTemplatePath,                                   // absolute
                ltrim($subTemplatePath, '/'),                       // relative to script dir
                BACKBONEPHP_APP_DIR . ltrim($subTemplatePath, '/'), // relative to app dir
                BACKBONEPHP_DIR . ltrim($subTemplatePath, '/')      // relative to BackbonePHP dir
            ];
            $content = "[notFound:$subTemplatePath]";
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    break;
                }
            }
            return (new Template($this->config, $this->data))
                ->setContent($content)
                ->render()
                ->getContent()
            ;
        }, $this->content);
        return $this;
    }
    
}
