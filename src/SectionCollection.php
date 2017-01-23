<?php

namespace PHPLegends\View;

use PHPLegends\View\Section;
use PHPLegends\Collections\Collection;

/**
 * Collection of view sections
 * 
 * @author Wallace de Souza vizerra <wallacemaxters@gmail.com>
*/
class SectionCollection extends Collection
{

    /**
     * 
     * @param string $name
     * @return \PHPLegends\Legendary\Section
    */

    public function findOrCreate($name)
    {
        $section = $this->getOrDefault($name);

        if (! $section) {

            $this->attach($section = new Section($name));
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


    /**
     * Gets the last started section
     * 
     * @return PHPLegends\View\Section|null
     * */

    public function lastStarted()
    {
        return $this->last(function (Section $section) {
            return ! $section->isClosed();
        });
    }
}