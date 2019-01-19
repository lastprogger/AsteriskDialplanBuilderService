<?php


namespace App\Domain\Service\DialplanBuilders;

class BuildContext
{
    /**
     * @var string
     */
    private $companyId;
    /**
     * @var string
     */
    private $pbxSchemeId;
    /**
     * @var string
     */
    private $pbxId;

    /**
     * BuildContext constructor.
     *
     * @param string $companyId
     * @param string $pbxSchemeId
     * @param string $pbxId
     */
    public function __construct(string $companyId, string $pbxSchemeId, string $pbxId)
    {
        $this->companyId   = $companyId;
        $this->pbxSchemeId = $pbxSchemeId;
        $this->pbxId       = $pbxId;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     *
     * @return BuildContext
     */
    public function setCompanyId(string $companyId): BuildContext
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPbxSchemeId(): string
    {
        return $this->pbxSchemeId;
    }

    /**
     * @param string $pbxSchemeId
     *
     * @return BuildContext
     */
    public function setPbxSchemeId(string $pbxSchemeId): BuildContext
    {
        $this->pbxSchemeId = $pbxSchemeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPbxId(): string
    {
        return $this->pbxId;
    }

    /**
     * @param string $pbxId
     *
     * @return BuildContext
     */
    public function setPbxId(string $pbxId): BuildContext
    {
        $this->pbxId = $pbxId;

        return $this;
    }



}