<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.21
 * Time: 11.06
 */
namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var PasswordUpdaterInterface
     */
    private $passwordUpdater;

    public function __construct(PasswordUpdaterInterface $passwordUpdater, UserManagerInterface $userManager)
    {
        $this->passwordUpdater = $passwordUpdater;
        $this->userManager = $userManager;
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadLocations($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {

        foreach ($this->getUserData() as $userData) {
            /** @var User $user */
            $user = $this->userManager->createUser();

            $user->setFirstName($userData[0]);
            $user->setLastName($userData[1]);
            $user->setUsername($userData[2]);
            $user->setEmail($userData[3]);
            $user->setPlainPassword($userData[4]);
            $this->passwordUpdater->hashPassword($user);
            $user->setEnabled(true);
            $user->setRoles($userData[5]);

            $manager->persist($user);
        }

        $manager->flush();
    }


    /**
     * @param ObjectManager $manager
     */
    private function loadLocations(ObjectManager $manager)
    {
        foreach ($this->getLocations() as $countryName => $cities) {
            $country = new Country();
            $country->setName($countryName);

            foreach ($cities as $cityName) {
                $city = new City();
                $city->setName($cityName);
                $country->addCity($city);
                $manager->persist($city);
            }
            $manager->persist($country);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$firstName, $lastName, $username, $email, $password, $roles];
            ['Jane', 'Doe', 'jane_doe', 'jane_doe@gmail.com', 'rootroot', ['ROLE_USER']],
            ['Antanas', null, 'antanas', 'anatanas@gmail.com', 'rootroot', ['ROLE_USER']],
            ['Petras', 'Marcius', 'petras_marcius', 'petras@gmail.com', 'rootroot', ['ROLE_ADMIN']],
            ['Jonas', 'Batonas', 'jonas_batonas', 'jonas@gmail.com', 'rootroot', ['ROLE_SUPER_ADMIN']],
        ];
    }

    /**
     * @return array
     */
    private function getLocations()
    {
        return [
            'Lietuva' => [
                'Akmenė',
                'Alytus',
                'Anykščiai',
                'Ariogala',
                'Baltoji Vokė',
                'Birštonas',
                'Biržai',
                'Daugai',
                'Druskininkai',
                'Dūkštas',
                'Dusetos',
                'Eišiškės',
                'Elektrėnai',
                'Ežerėlis',
                'Gargždai',
                'Garliava',
                'Gelgaudiškis',
                'Grigiškės',
                'Ignalina',
                'Jieznas',
                'Jonava',
                'Joniškėlis',
                'Joniškis',
                'Jurbarkas',
                'Kaišiadorys',
                'Kalvarija',
                'Kaunas',
                'Kavarskas',
                'Kazlų Rūda',
                'Kėdainiai',
                'Kelmė',
                'Kybartai',
                'Klaipėda',
                'Kretinga',
                'Kudirkos Naumiestis',
                'Kupiškis',
                'Kuršėnai',
                'Lazdijai',
                'Lentvaris',
                'Linkuva',
                'Marijampolė',
                'Mažeikiai',
                'Molėtai',
                'Naujoji Akmenė',
                'Nemenčinė',
                'Neringa',
                'Obeliai',
                'Pabradė',
                'Pagėgiai',
                'Pakruojis',
                'Palanga',
                'Pandėlys',
                'Panemunė',
                'Panevėžys',
                'Pasvalys',
                'Plungė',
                'Priekulė',
                'Prienai',
                'Radviliškis',
                'Ramygala',
                'Raseiniai',
                'Rietavas',
                'Rokiškis',
                'Rūdiškės',
                'Salantai',
                'Seda',
                'Simnas',
                'Skaudvilė',
                'Skuodas',
                'Smalininkai',
                'Subačius',
                'Šakiai',
                'Šalčininkai',
                'Šeduva',
                'Šiauliai',
                'Šilalė',
                'Šilutė',
                'Trakai',
                'Troškūnai',
                'Ukmergė',
                'Utena',
                'Užventis',
                'Vabalninkas',
                'Varėna',
                'Varniai',
                'Veisiejai',
                'Venta',
                'Viekšniai',
                'Vievis',
                'Vilkaviškis',
                'Vilkija',
                'Vilnius',
                'Virbalis',
                'Visaginas',
                'Zarasai',
                'Žagarė',
                'Žiežmariai',
                'Vilnius',
                'Virbalis',
                'Visaginas',
                'Zarasai',
                'Žagarė',
                'Žiežmariai'
            ]
        ];
    }
}
