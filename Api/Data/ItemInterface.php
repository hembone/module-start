<?php
/**
 * [Namespace] [Module] Extension
 *
 * @category [Namespace]
 * @package [Namespace]_[Module]
 * @copyright [phpdocs_copyright]
 * @author [phpdocs_author]
 */

namespace [Namespace]\[Module]\Api\Data;

interface ItemInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ITEM_ID      = '[db_name]_id';
    const URL_KEY       = 'url_key';
    const NAME          = 'name';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get URL Key
     *
     * @return string
     */
    public function getUrlKey();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return \[Namespace]\[Module]\Api\Data\ItemInterface
     */
    public function setId($id);

    /**
     * Set URL Key
     *
     * @param string $url_key
     * @return \[Namespace]\[Module]\Api\Data\ItemInterface
     */
    public function setUrlKey($url_key);

    /**
     * Return full URL including base url.
     *
     * @return mixed
     */
    public function getUrl();

    /**
     * Set name
     *
     * @param string $name
     * @return \[Namespace]\[Module]\Api\Data\ItemInterface
     */
    public function setName($name);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \[Namespace]\[Module]\Api\Data\ItemInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \[Namespace]\[Module]\Api\Data\ItemInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \[Namespace]\[Module]\Api\Data\ItemInterface
     */
    public function setIsActive($isActive);
}
