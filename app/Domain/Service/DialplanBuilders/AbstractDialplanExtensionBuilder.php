<?php


namespace App\Domain\Service\DialplanBuilders;


use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;

abstract class AbstractDialplanExtensionBuilder implements DialplanExtensionBuilderInterface
{
    /**
     * @var Extension
     */
    protected $exten;
    /**
     * @var Dialplan
     */
    protected $dialplan;
    /**
     * @var array
     */
    protected $relatedExtensions = [];
    /**
     * @var array
     */
    protected $data;
    /**
     * @var string
     */
    protected $nodeId;
    /**
     * @var string
     */
    protected $nodeType;

    /**
     * {@inheritdoc}
     */
    public function __construct(Dialplan $dialplan, array $data)
    {
        $this->exten    = $dialplan->createExtension();
        $this->dialplan = $dialplan;
        $this->data     = $data;
        $this->nodeId   = $data['id'];
        $this->nodeType = $data['node_type']['type'];
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension(): Extension
    {
        return $this->exten;
    }

    /**
     * {@inheritdoc}
     */
    public function addRelatedExtension(Extension $extension, string $relationType): void
    {
        $this->relatedExtensions[] = [
            'extension' => $extension,
            'type'      => $relationType,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function build(): Extension
    {
        $text = 'Node ' . $this->data['id'] . ' is executing';
        $this->exten->addPriority($this->dialplan->NoOp($text), 'start');

        $this->doBuild();

        if ($this->nodeType === 'action' && !empty($this->relatedExtensions)) {
            $extension = array_pop($this->relatedExtensions)['extension'];
            $context   = config('dialplan.default_context');
            $this->exten->addPriority(
                $this->dialplan->GoToStatement('start', $extension->getName(), $context)
            );
        }

        return $this->exten;
    }

    /**
     * @return Extension
     */
    abstract protected function doBuild(): Extension;
}
