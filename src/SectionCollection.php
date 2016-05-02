<?php

namespace PHPLegends\View;

use PHPLegends\Collections\Collection;

/**
* @author Wallace de Souza vizerra <wallacemaxters@gmail.com>
*/
class SectionCollection extends Collection
{

    /**
    * @param string $name
    * @return \PHPLegends\Legendary\Section
    */

    public function findOrCreate($name)
    {

        $section = $this->getOrDefault($name);

        if (! $section) {

            $section = new Section($name);

            $this->attach($section);

            return $section;
        }

        return $section;
    }

    /**
    * Attaches the section in current collection
    * @return \PHPLegends\Legendary\SectionCollection
    */
    public function attach(Section $section)
    {
        $this->set($section->getName(), $section);

        return $this;
    }

    /**
    * Detaches the section from current collection
    * @return \PHPLegends\Legendary\SectionCollection
    */
    public function detach(Section $section)
    {
        $this->remove($section);

        return $this;
    }

    /**
    * Detaches the section by name from current collection
    * @return \PHPLegends\Legendary\SectionCollection
    */
    public function detachByName($name)
    {
        $this->delete($name);

        return $this;
    }
}