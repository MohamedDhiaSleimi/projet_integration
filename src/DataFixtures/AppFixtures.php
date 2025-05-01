<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\InternshipOffer;
use App\Entity\Student;
use App\Entity\Application;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create Admin User
        $admin = new Admin();
        $admin->setEmail('admin@example.com')
            ->setName('Admin User')
            ->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin123');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Create Students
        $student1 = new Student();
        $student1->setName('John Doe')
            ->setEmail('john@example.com')
            ->setUniversity('University of Technology')
            ->setFieldOfStudy('Computer Science')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student1, 'password');
        $student1->setPassword($hashedPassword);
        $manager->persist($student1);

        $student2 = new Student();
        $student2->setName('Jane Smith')
            ->setEmail('jane@example.com')
            ->setUniversity('Business School')
            ->setFieldOfStudy('Marketing')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student2, 'password');
        $student2->setPassword($hashedPassword);
        $manager->persist($student2);

        // Create Companies
        $company1 = new Company();
        $company1->setName('Tech Solutions Inc.')
            ->setEmail('contact@techsolutions.com')
            ->setIndustry('Information Technology')
            ->setLocation('Paris')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company1, 'password');
        $company1->setPassword($hashedPassword);
        $manager->persist($company1);

        $company2 = new Company();
        $company2->setName('Marketing Pro')
            ->setEmail('info@marketingpro.com')
            ->setIndustry('Marketing')
            ->setLocation('Lyon')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company2, 'password');
        $company2->setPassword($hashedPassword);
        $manager->persist($company2);

        // Create Internship Offers
        $offer1 = new InternshipOffer();
        $offer1->setTitle('Web Developer Intern')
            ->setDescription('Join our team to develop web applications using modern frameworks.')
            ->setLocation('Paris')
            ->setDuration('6 months')
            ->setCompany($company1);
        $manager->persist($offer1);

        $offer2 = new InternshipOffer();
        $offer2->setTitle('Mobile App Developer')
            ->setDescription('Work on exciting mobile applications for iOS and Android.')
            ->setLocation('Remote')
            ->setDuration('3 months')
            ->setCompany($company1);
        $manager->persist($offer2);

        $offer3 = new InternshipOffer();
        $offer3->setTitle('Digital Marketing Intern')
            ->setDescription('Learn about digital marketing strategies and implement campaigns.')
            ->setLocation('Lyon')
            ->setDuration('4 months')
            ->setCompany($company2);
        $manager->persist($offer3);

        // Create Applications
        $application1 = new Application();
        $application1->setStudent($student1)
            ->setInternshipOffer($offer1)
            ->setStatus('pending');
        $manager->persist($application1);

        $application2 = new Application();
        $application2->setStudent($student2)
            ->setInternshipOffer($offer3)
            ->setStatus('accepted');
        $manager->persist($application2);

        $manager->flush();
    }
}
