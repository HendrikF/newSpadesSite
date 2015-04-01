<?php

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Tag;

class TagsToStringTransformer implements DataTransformerInterface
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Model => View
     */
    public function transform($tags)
    {
        $titles = array();
        foreach($tags as $tag) {
            $titles[] = $tag->getTitle();
        }
        return implode(', ', $titles);
    }

    /**
     * View => Model
     */
    public function reverseTransform($input)
    {
        if(!$input) {
            return array();
        }
        $titles = array_filter(array_map('trim', explode(',', $input)));
        $tags = array();
        foreach($titles as $title) {
            $tag = $this->om
                ->getRepository('AppBundle:Tag')
                ->findOneBy(array('title' => $title));
            if(!$tag) {
                $tag = new Tag();
                $tag->setTitle($title);
                $this->om->persist($tag);
            }
            $tags[] = $tag;
        }
        return $tags;
    }
}
