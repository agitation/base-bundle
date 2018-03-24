<?php
declare(strict_types=1);

/*
 * @package    agitation/base-bundle
 * @link       http://github.com/agitation/base-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait NameAwareTrait
{
    /**
     * @ORM\Column(type="string", length=70)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
