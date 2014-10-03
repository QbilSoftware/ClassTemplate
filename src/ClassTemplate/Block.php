<?php
namespace ClassTemplate;
use ClassTemplate\Utils;

class Block
{
    public $lines = array();

    public $args = array();

    public $indent = 0;

    public function setDefaultArguments(array $args)
    {
        $this->args = $args;
    }

    public function setBody($text) {
        $this->lines = explode("\n", $text);
    }

    public function appendLine($line) {
        $this->lines[] = $line;
    }

    public function indent() {
        $this->indent++;
    }

    public function unindent() {
        $this->indent--;
    }

    public function setIndent($indent) {
        $this->indent = $indent;
    }

    public function render($args = array(), $allowIndent = true) {
        if ($allowIndent) {
            $space = str_repeat("    ", $this->indent);
            $body = $space . join("\n" . $space,$this->lines) . "\n";
        } else {
            $body = $space . join("\n",$this->lines) . "\n";
        }
        return Utils::renderStringTemplate($body, array_merge($this->args,$args));
    }

}



