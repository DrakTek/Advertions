<?php
    namespace Drak\BlogBundle\DataFIxtures\ORM;

    use Doctrine\Common\DataFixtures\FixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use Drak\BlogBundle\Entity\Category;

    class LoadCategory implements FixtureInterface
    {
        public function load(ObjectManager $manager)
        {
            $names = array(
                'Developpement web',
                'Developpement Mobile',
                'Graphisme',
                'Integration',
                'Reseau'
            );

            foreach ($names as $name){
                $category = new Category();
                $category->setName($name);
                $manager->persist($category);
            }

            $manager->flush();
        }

        // public function getOrder()
        // {
        //     return 1; // the order in which fixtures will be loaded
        // }
    }
