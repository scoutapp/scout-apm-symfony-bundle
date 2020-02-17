<?php
/**
 * @noinspection PhpInternalEntityUsedInspection
 * @noinspection TransitiveDependenciesUsageInspection
 */

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\Twig;

use Scoutapm\ScoutApmAgent;
use Twig\Compiler;
use Twig\Environment as Twig;
use Twig\Extension\ExtensionInterface;
use Twig\Lexer;
use Twig\Loader\LoaderInterface;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\Parser;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;
use Twig\TokenParser\TokenParserInterface;
use Twig\TokenStream;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class TwigDecorator extends Twig
{
    /** @var Twig */
    private $twig;
    /** @var ScoutApmAgent */
    private $agent;

    public function __construct(Twig $twig, ScoutApmAgent $agent)
    {
        $this->twig  = $twig;
        $this->agent = $agent;
    }

    /** @return mixed */
    private function instrument(string $name, callable $callable)
    {
        return $this->agent->instrument(
            'View',
            $name,
            $callable
        );
    }

    /** {@inheritDoc} */
    public function enableDebug()
    {
        $this->twig->enableDebug();
    }

    /** {@inheritDoc} */
    public function disableDebug()
    {
        $this->twig->disableDebug();
    }

    /** {@inheritDoc} */
    public function isDebug()
    {
        return $this->twig->isDebug();
    }

    /** {@inheritDoc} */
    public function enableAutoReload()
    {
        $this->twig->enableAutoReload();
    }

    /** {@inheritDoc} */
    public function disableAutoReload()
    {
        $this->twig->disableAutoReload();
    }

    /** {@inheritDoc} */
    public function isAutoReload()
    {
        return $this->twig->isAutoReload();
    }

    /** {@inheritDoc} */
    public function enableStrictVariables()
    {
        $this->twig->enableStrictVariables();
    }

    /** {@inheritDoc} */
    public function disableStrictVariables()
    {
        $this->twig->disableStrictVariables();
    }

    /** {@inheritDoc} */
    public function isStrictVariables()
    {
        return $this->twig->isStrictVariables();
    }

    /** {@inheritDoc} */
    public function getCache($original = true)
    {
        return $this->twig->getCache($original);
    }

    /** {@inheritDoc} */
    public function setCache($cache)
    {
        $this->twig->setCache($cache);
    }

    /** {@inheritDoc} */
    public function getTemplateClass(string $name, ?int $index = null) : string
    {
        return $this->twig->getTemplateClass($name, $index);
    }

    /** {@inheritDoc} */
    public function render($name, array $context = []) : string
    {
        return $this->instrument(
            $name,
            function () use ($name, $context) {
                return $this->twig->render($name, $context);
            }
        );
    }

    /** {@inheritDoc} */
    public function display($name, array $context = []) : void
    {
        $this->instrument(
            $name,
            function () use ($name, $context) : void {
                $this->twig->display($name, $context);
            }
        );
    }

    /** {@inheritDoc} */
    public function load($name) : TemplateWrapper
    {
        return $this->twig->load($name);
    }

    /** {@inheritDoc} */
    public function loadTemplate(string $cls, string $name, ?int $index = null) : Template
    {
        return $this->twig->loadTemplate($cls, $name, $index);
    }

    /** {@inheritDoc} */
    public function createTemplate(string $template, ?string $name = null) : TemplateWrapper
    {
        return $this->twig->createTemplate($template, $name);
    }

    /** {@inheritDoc} */
    public function isTemplateFresh(string $name, int $time) : bool
    {
        return $this->twig->isTemplateFresh($name, $time);
    }

    /** {@inheritDoc} */
    public function resolveTemplate($names) : TemplateWrapper
    {
        return $this->twig->resolveTemplate($names);
    }

    /** {@inheritDoc} */
    public function setLexer(Lexer $lexer)
    {
        $this->twig->setLexer($lexer);
    }

    /** {@inheritDoc} */
    public function tokenize(Source $source) : TokenStream
    {
        return $this->twig->tokenize($source);
    }

    /** {@inheritDoc} */
    public function setParser(Parser $parser)
    {
        $this->twig->setParser($parser);
    }

    /** {@inheritDoc} */
    public function parse(TokenStream $stream) : ModuleNode
    {
        return $this->twig->parse($stream);
    }

    /** {@inheritDoc} */
    public function setCompiler(Compiler $compiler)
    {
        $this->twig->setCompiler($compiler);
    }

    /** {@inheritDoc} */
    public function compile(Node $node) : string
    {
        return $this->twig->compile($node);
    }

    /** {@inheritDoc} */
    public function compileSource(Source $source) : string
    {
        return $this->twig->compileSource($source);
    }

    /** {@inheritDoc} */
    public function setLoader(LoaderInterface $loader)
    {
        $this->twig->setLoader($loader);
    }

    /** {@inheritDoc} */
    public function getLoader() : LoaderInterface
    {
        return $this->twig->getLoader();
    }

    /** {@inheritDoc} */
    public function setCharset(string $charset)
    {
        $this->twig->setCharset($charset);
    }

    /** {@inheritDoc} */
    public function getCharset() : string
    {
        return $this->twig->getCharset();
    }

    /** {@inheritDoc} */
    public function hasExtension(string $class) : bool
    {
        return $this->twig->hasExtension($class);
    }

    /** {@inheritDoc} */
    public function addRuntimeLoader(RuntimeLoaderInterface $loader)
    {
        $this->twig->addRuntimeLoader($loader);
    }

    /** {@inheritDoc} */
    public function getExtension(string $class) : ExtensionInterface
    {
        return $this->twig->getExtension($class);
    }

    /** {@inheritDoc} */
    public function getRuntime(string $class)
    {
        return $this->twig->getRuntime($class);
    }

    /** {@inheritDoc} */
    public function addExtension(ExtensionInterface $extension)
    {
        $this->twig->addExtension($extension);
    }

    /** {@inheritDoc} */
    public function setExtensions(array $extensions)
    {
        $this->twig->setExtensions($extensions);
    }

    /** {@inheritDoc} */
    public function getExtensions() : array
    {
        return $this->twig->getExtensions();
    }

    /** {@inheritDoc} */
    public function addTokenParser(TokenParserInterface $parser)
    {
        $this->twig->addTokenParser($parser);
    }

    /** {@inheritDoc} */
    public function getTokenParsers() : array
    {
        return $this->twig->getTokenParsers();
    }

    /** {@inheritDoc} */
    public function getTags() : array
    {
        return $this->twig->getTags();
    }

    /** {@inheritDoc} */
    public function addNodeVisitor(NodeVisitorInterface $visitor)
    {
        $this->twig->addNodeVisitor($visitor);
    }

    /** {@inheritDoc} */
    public function getNodeVisitors() : array
    {
        return $this->twig->getNodeVisitors();
    }

    /** {@inheritDoc} */
    public function addFilter(TwigFilter $filter)
    {
        $this->twig->addFilter($filter);
    }

    /** {@inheritDoc} */
    public function getFilter(string $name) : ?TwigFilter
    {
        return $this->twig->getFilter($name);
    }

    /** {@inheritDoc} */
    public function registerUndefinedFilterCallback(callable $callable)
    {
        $this->twig->registerUndefinedFilterCallback($callable);
    }

    /** {@inheritDoc} */
    public function getFilters() : array
    {
        return $this->twig->getFilters();
    }

    /** {@inheritDoc} */
    public function addTest(TwigTest $test)
    {
        $this->twig->addTest($test);
    }

    /** {@inheritDoc} */
    public function getTests() : array
    {
        return $this->twig->getTests();
    }

    /** {@inheritDoc} */
    public function getTest(string $name) : ?TwigTest
    {
        return $this->twig->getTest($name);
    }

    /** {@inheritDoc} */
    public function addFunction(TwigFunction $function)
    {
        $this->twig->addFunction($function);
    }

    /** {@inheritDoc} */
    public function getFunction(string $name) : ?TwigFunction
    {
        return $this->twig->getFunction($name);
    }

    /** {@inheritDoc} */
    public function registerUndefinedFunctionCallback(callable $callable)
    {
        $this->twig->registerUndefinedFunctionCallback($callable);
    }

    /** {@inheritDoc} */
    public function getFunctions() : array
    {
        return $this->twig->getFunctions();
    }

    /** {@inheritDoc} */
    public function addGlobal(string $name, $value)
    {
        $this->twig->addGlobal($name, $value);
    }

    /** {@inheritDoc} */
    public function getGlobals() : array
    {
        return $this->twig->getGlobals();
    }

    /** {@inheritDoc} */
    public function mergeGlobals(array $context) : array
    {
        return $this->twig->mergeGlobals($context);
    }

    /** {@inheritDoc} */
    public function getUnaryOperators() : array
    {
        return $this->twig->getUnaryOperators();
    }

    /** {@inheritDoc} */
    public function getBinaryOperators() : array
    {
        return $this->twig->getBinaryOperators();
    }
}
