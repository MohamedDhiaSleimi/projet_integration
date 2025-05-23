<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\InternshipOffer;
use App\Entity\Student;
use App\Entity\Application;
use App\Entity\Admin;
use App\Entity\Supervisor;
use App\Entity\CV;
use App\Entity\SeanceEncadrement;
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
        $admin->setEmail('admin@internship-platform.com')
            ->setName('System Administrator')
            ->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin123');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Create Supervisors
        $supervisors = [];
        
        $supervisor1 = new Supervisor();
        $supervisor1->setName('Dr. Emily Carter')
            ->setEmail('emily.carter@university.edu')
            ->setDepartment('Computer Science')
            ->setPhoneNumber('0123456789')
            ->setRoles(['ROLE_SUPERVISOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($supervisor1, 'supervisor123');
        $supervisor1->setPassword($hashedPassword);
        $manager->persist($supervisor1);
        $supervisors[] = $supervisor1;

        $supervisor2 = new Supervisor();
        $supervisor2->setName('Prof. Michael Johnson')
            ->setEmail('michael.johnson@university.edu')
            ->setDepartment('Business Administration')
            ->setPhoneNumber('0123456790')
            ->setRoles(['ROLE_SUPERVISOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($supervisor2, 'supervisor123');
        $supervisor2->setPassword($hashedPassword);
        $manager->persist($supervisor2);
        $supervisors[] = $supervisor2;

        $supervisor3 = new Supervisor();
        $supervisor3->setName('Dr. Sarah Martinez')
            ->setEmail('sarah.martinez@university.edu')
            ->setDepartment('Engineering')
            ->setPhoneNumber('0123456791')
            ->setRoles(['ROLE_SUPERVISOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($supervisor3, 'supervisor123');
        $supervisor3->setPassword($hashedPassword);
        $manager->persist($supervisor3);
        $supervisors[] = $supervisor3;

        $supervisor4 = new Supervisor();
        $supervisor4->setName('Prof. David Wilson')
            ->setEmail('david.wilson@university.edu')
            ->setDepartment('Marketing')
            ->setPhoneNumber('0123456792')
            ->setRoles(['ROLE_SUPERVISOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($supervisor4, 'supervisor123');
        $supervisor4->setPassword($hashedPassword);
        $manager->persist($supervisor4);
        $supervisors[] = $supervisor4;

        // Create Students
        $students = [];
        
        $student1 = new Student();
        $student1->setName('John Doe')
            ->setEmail('john.doe@student.edu')
            ->setUniversity('University of Technology Paris')
            ->setFieldOfStudy('Computer Science')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student1, 'password123');
        $student1->setPassword($hashedPassword);
        $manager->persist($student1);
        $students[] = $student1;

        $student2 = new Student();
        $student2->setName('Jane Smith')
            ->setEmail('jane.smith@student.edu')
            ->setUniversity('Business School Lyon')
            ->setFieldOfStudy('Marketing')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student2, 'password123');
        $student2->setPassword($hashedPassword);
        $manager->persist($student2);
        $students[] = $student2;

        $student3 = new Student();
        $student3->setName('Alex Johnson')
            ->setEmail('alex.johnson@student.edu')
            ->setUniversity('Engineering Institute')
            ->setFieldOfStudy('Software Engineering')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student3, 'password123');
        $student3->setPassword($hashedPassword);
        $manager->persist($student3);
        $students[] = $student3;

        $student4 = new Student();
        $student4->setName('Maria Garcia')
            ->setEmail('maria.garcia@student.edu')
            ->setUniversity('Digital Arts College')
            ->setFieldOfStudy('Web Design')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student4, 'password123');
        $student4->setPassword($hashedPassword);
        $manager->persist($student4);
        $students[] = $student4;

        $student5 = new Student();
        $student5->setName('Robert Brown')
            ->setEmail('robert.brown@student.edu')
            ->setUniversity('Tech University')
            ->setFieldOfStudy('Data Science')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student5, 'password123');
        $student5->setPassword($hashedPassword);
        $manager->persist($student5);
        $students[] = $student5;

        $student6 = new Student();
        $student6->setName('Lisa Anderson')
            ->setEmail('lisa.anderson@student.edu')
            ->setUniversity('Business Academy')
            ->setFieldOfStudy('Digital Marketing')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student6, 'password123');
        $student6->setPassword($hashedPassword);
        $manager->persist($student6);
        $students[] = $student6;

        $student7 = new Student();
        $student7->setName('Thomas Wilson')
            ->setEmail('thomas.wilson@student.edu')
            ->setUniversity('IT Institute')
            ->setFieldOfStudy('Cybersecurity')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student7, 'password123');
        $student7->setPassword($hashedPassword);
        $manager->persist($student7);
        $students[] = $student7;

        $student8 = new Student();
        $student8->setName('Emma Davis')
            ->setEmail('emma.davis@student.edu')
            ->setUniversity('Creative University')
            ->setFieldOfStudy('UX/UI Design')
            ->setRoles(['ROLE_STUDENT']);
        $hashedPassword = $this->passwordHasher->hashPassword($student8, 'password123');
        $student8->setPassword($hashedPassword);
        $manager->persist($student8);
        $students[] = $student8;

        // Create CVs for some students
        $cv1 = new CV();
        $cv1->setStudent($student1)
            ->setFilename('Resume-683093a19d115.pdf');
        $manager->persist($cv1);

        $cv2 = new CV();
        $cv2->setStudent($student2)
            ->setFilename('Resume-683093a19d115.pdf');
        $manager->persist($cv2);

        $cv3 = new CV();
        $cv3->setStudent($student5)
            ->setFilename('Resume-683093a19d115.pdf');
        $manager->persist($cv3);

        $cv4 = new CV();
        $cv4->setStudent($student7)
            ->setFilename('Resume-683093a19d115.pdf');
        $manager->persist($cv4);

        // Create Companies
        $companies = [];
        
        $company1 = new Company();
        $company1->setName('Tech Solutions Inc.')
            ->setEmail('contact@techsolutions.com')
            ->setIndustry('Information Technology')
            ->setLocation('Paris')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company1, 'company123');
        $company1->setPassword($hashedPassword);
        $manager->persist($company1);
        $companies[] = $company1;

        $company2 = new Company();
        $company2->setName('Digital Marketing Pro')
            ->setEmail('info@marketingpro.com')
            ->setIndustry('Marketing & Advertising')
            ->setLocation('Lyon')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company2, 'company123');
        $company2->setPassword($hashedPassword);
        $manager->persist($company2);
        $companies[] = $company2;

        $company3 = new Company();
        $company3->setName('InnovateTech Startups')
            ->setEmail('careers@innovatetech.com')
            ->setIndustry('Software Development')
            ->setLocation('Nice')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company3, 'company123');
        $company3->setPassword($hashedPassword);
        $manager->persist($company3);
        $companies[] = $company3;

        $company4 = new Company();
        $company4->setName('Creative Design Agency')
            ->setEmail('hello@creativedesign.com')
            ->setIndustry('Design & Creative')
            ->setLocation('Marseille')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company4, 'company123');
        $company4->setPassword($hashedPassword);
        $manager->persist($company4);
        $companies[] = $company4;

        $company5 = new Company();
        $company5->setName('DataViz Analytics')
            ->setEmail('contact@dataviz.com')
            ->setIndustry('Data Analytics')
            ->setLocation('Toulouse')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company5, 'company123');
        $company5->setPassword($hashedPassword);
        $manager->persist($company5);
        $companies[] = $company5;

        $company6 = new Company();
        $company6->setName('SecureNet Systems')
            ->setEmail('hr@securenet.com')
            ->setIndustry('Cybersecurity')
            ->setLocation('Strasbourg')
            ->setRoles(['ROLE_COMPANY']);
        $hashedPassword = $this->passwordHasher->hashPassword($company6, 'company123');
        $company6->setPassword($hashedPassword);
        $manager->persist($company6);
        $companies[] = $company6;

        // Create Internship Offers
        $offers = [];
        
        $offer1 = new InternshipOffer();
        $offer1->setTitle('Full Stack Web Developer Intern')
            ->setDescription('Join our dynamic team to develop modern web applications using React, Node.js, and PostgreSQL. You will work on real projects and gain hands-on experience with agile development methodologies.')
            ->setLocation('Paris')
            ->setDuration('6 months')
            ->setCompany($company1)
            ->setIsActive(true);
        $manager->persist($offer1);
        $offers[] = $offer1;

        $offer2 = new InternshipOffer();
        $offer2->setTitle('Mobile App Developer')
            ->setDescription('Work on exciting mobile applications for iOS and Android platforms. Experience with React Native or Flutter is a plus. You will be mentored by senior developers.')
            ->setLocation('Remote')
            ->setDuration('4 months')
            ->setCompany($company1)
            ->setIsActive(true);
        $manager->persist($offer2);
        $offers[] = $offer2;

        $offer3 = new InternshipOffer();
        $offer3->setTitle('Digital Marketing Specialist Intern')
            ->setDescription('Learn about digital marketing strategies, SEO, content marketing, and social media management. Implement real campaigns for our clients and analyze their performance.')
            ->setLocation('Lyon')
            ->setDuration('5 months')
            ->setCompany($company2)
            ->setIsActive(true);
        $manager->persist($offer3);
        $offers[] = $offer3;

        $offer4 = new InternshipOffer();
        $offer4->setTitle('Social Media Marketing Intern')
            ->setDescription('Manage social media accounts, create engaging content, and analyze social media metrics. Perfect for students interested in brand management and digital communication.')
            ->setLocation('Lyon')
            ->setDuration('3 months')
            ->setCompany($company2)
            ->setIsActive(true);
        $manager->persist($offer4);
        $offers[] = $offer4;

        $offer5 = new InternshipOffer();
        $offer5->setTitle('Software Engineering Intern')
            ->setDescription('Contribute to innovative software projects using cutting-edge technologies. Work with microservices, cloud platforms, and DevOps practices.')
            ->setLocation('Nice')
            ->setDuration('6 months')
            ->setCompany($company3)
            ->setIsActive(true);
        $manager->persist($offer5);
        $offers[] = $offer5;

        $offer6 = new InternshipOffer();
        $offer6->setTitle('UX/UI Design Intern')
            ->setDescription('Design user interfaces for web and mobile applications. Work closely with our design team to create intuitive and beautiful user experiences.')
            ->setLocation('Marseille')
            ->setDuration('4 months')
            ->setCompany($company4)
            ->setIsActive(true);
        $manager->persist($offer6);
        $offers[] = $offer6;

        $offer7 = new InternshipOffer();
        $offer7->setTitle('Data Science Intern')
            ->setDescription('Analyze large datasets, create predictive models, and build data visualizations. Experience with Python, R, or SQL is required.')
            ->setLocation('Toulouse')
            ->setDuration('5 months')
            ->setCompany($company5)
            ->setIsActive(true);
        $manager->persist($offer7);
        $offers[] = $offer7;

        $offer8 = new InternshipOffer();
        $offer8->setTitle('Cybersecurity Analyst Intern')
            ->setDescription('Learn about network security, vulnerability assessment, and incident response. Work with industry-standard security tools and frameworks.')
            ->setLocation('Strasbourg')
            ->setDuration('6 months')
            ->setCompany($company6)
            ->setIsActive(true);
        $manager->persist($offer8);
        $offers[] = $offer8;

        $offer9 = new InternshipOffer();
        $offer9->setTitle('Frontend Developer Intern')
            ->setDescription('Focus on creating responsive and interactive user interfaces using modern JavaScript frameworks like Vue.js or Angular.')
            ->setLocation('Paris')
            ->setDuration('4 months')
            ->setCompany($company1)
            ->setIsActive(false); // This one is inactive
        $manager->persist($offer9);
        $offers[] = $offer9;

        // Create Applications with various statuses
        $applications = [];
        
        // John Doe applications
        $app1 = new Application();
        $app1->setStudent($student1)
            ->setInternshipOffer($offer1)
            ->setStatus('accepted')
            ->setSupervisor($supervisor1)
            ->setStartDate(new \DateTime('2024-03-01'))
            ->setEndDate(new \DateTime('2024-08-31'));
        $manager->persist($app1);
        $applications[] = $app1;

        $app2 = new Application();
        $app2->setStudent($student1)
            ->setInternshipOffer($offer5)
            ->setStatus('rejected');
        $manager->persist($app2);
        $applications[] = $app2;

        // Jane Smith applications
        $app3 = new Application();
        $app3->setStudent($student2)
            ->setInternshipOffer($offer3)
            ->setStatus('accepted')
            ->setSupervisor($supervisor2)
            ->setStartDate(new \DateTime('2024-02-15'))
            ->setEndDate(new \DateTime('2024-07-15'));
        $manager->persist($app3);
        $applications[] = $app3;

        $app4 = new Application();
        $app4->setStudent($student2)
            ->setInternshipOffer($offer4)
            ->setStatus('pending');
        $manager->persist($app4);
        $applications[] = $app4;

        // Alex Johnson applications
        $app5 = new Application();
        $app5->setStudent($student3)
            ->setInternshipOffer($offer5)
            ->setStatus('accepted')
            ->setSupervisor($supervisor3)
            ->setStartDate(new \DateTime('2024-04-01'))
            ->setEndDate(new \DateTime('2024-09-30'));
        $manager->persist($app5);
        $applications[] = $app5;

        // Maria Garcia applications
        $app6 = new Application();
        $app6->setStudent($student4)
            ->setInternshipOffer($offer6)
            ->setStatus('pending');
        $manager->persist($app6);
        $applications[] = $app6;

        $app7 = new Application();
        $app7->setStudent($student4)
            ->setInternshipOffer($offer2)
            ->setStatus('rejected');
        $manager->persist($app7);
        $applications[] = $app7;

        // Robert Brown applications
        $app8 = new Application();
        $app8->setStudent($student5)
            ->setInternshipOffer($offer7)
            ->setStatus('accepted')
            ->setSupervisor($supervisor1)
            ->setStartDate(new \DateTime('2024-03-15'))
            ->setEndDate(new \DateTime('2024-08-15'));
        $manager->persist($app8);
        $applications[] = $app8;

        // Lisa Anderson applications
        $app9 = new Application();
        $app9->setStudent($student6)
            ->setInternshipOffer($offer3)
            ->setStatus('pending');
        $manager->persist($app9);
        $applications[] = $app9;

        $app10 = new Application();
        $app10->setStudent($student6)
            ->setInternshipOffer($offer4)
            ->setStatus('accepted')
            ->setSupervisor($supervisor4)
            ->setStartDate(new \DateTime('2024-05-01'))
            ->setEndDate(new \DateTime('2024-07-31'));
        $manager->persist($app10);
        $applications[] = $app10;

        // Thomas Wilson applications
        $app11 = new Application();
        $app11->setStudent($student7)
            ->setInternshipOffer($offer8)
            ->setStatus('accepted')
            ->setSupervisor($supervisor3)
            ->setStartDate(new \DateTime('2024-02-01'))
            ->setEndDate(new \DateTime('2024-07-31'));
        $manager->persist($app11);
        $applications[] = $app11;

        // Emma Davis applications
        $app12 = new Application();
        $app12->setStudent($student8)
            ->setInternshipOffer($offer6)
            ->setStatus('pending');
        $manager->persist($app12);
        $applications[] = $app12;

        $app13 = new Application();
        $app13->setStudent($student8)
            ->setInternshipOffer($offer1)
            ->setStatus('rejected');
        $manager->persist($app13);
        $applications[] = $app13;

        // Create Seance Encadrement (Supervision Sessions) for accepted applications with supervisors
        $seance1 = new SeanceEncadrement();
        $seance1->setDate(new \DateTime('2024-03-15 10:00:00'))
            ->setCommentaire('Initial meeting with student. Discussed project objectives and timeline. Student shows good understanding of requirements.')
            ->setEtudiant($student1)
            ->setSupervisor($supervisor1);
        $manager->persist($seance1);

        $seance2 = new SeanceEncadrement();
        $seance2->setDate(new \DateTime('2024-04-15 14:30:00'))
            ->setCommentaire('Progress review meeting. Student has completed the first milestone successfully. Good technical skills demonstrated.')
            ->setEtudiant($student1)
            ->setSupervisor($supervisor1);
        $manager->persist($seance2);

        $seance3 = new SeanceEncadrement();
        $seance3->setDate(new \DateTime('2024-03-01 09:00:00'))
            ->setCommentaire('Kick-off meeting for marketing internship. Outlined campaign strategies and KPIs to track.')
            ->setEtudiant($student2)
            ->setSupervisor($supervisor2);
        $manager->persist($seance3);

        $seance4 = new SeanceEncadrement();
        $seance4->setDate(new \DateTime('2024-04-01 11:00:00'))
            ->setCommentaire('Mid-term evaluation. Student has shown excellent creativity in campaign design. Exceeded expectations.')
            ->setEtudiant($student2)
            ->setSupervisor($supervisor2);
        $manager->persist($seance4);

        $seance5 = new SeanceEncadrement();
        $seance5->setDate(new \DateTime('2024-04-15 15:00:00'))
            ->setCommentaire('First supervision session for software engineering internship. Discussed architecture patterns and best practices.')
            ->setEtudiant($student3)
            ->setSupervisor($supervisor3);
        $manager->persist($seance5);

        $seance6 = new SeanceEncadrement();
        $seance6->setDate(new \DateTime('2024-04-01 10:30:00'))
            ->setCommentaire('Data science project initiation. Reviewed dataset and analytical approaches. Student prepared well.')
            ->setEtudiant($student5)
            ->setSupervisor($supervisor1);
        $manager->persist($seance6);

        $seance7 = new SeanceEncadrement();
        $seance7->setDate(new \DateTime('2024-05-15 13:00:00'))
            ->setCommentaire('Digital marketing internship progress review. Student successfully launched first campaign with impressive results.')
            ->setEtudiant($student6)
            ->setSupervisor($supervisor4);
        $manager->persist($seance7);

        $seance8 = new SeanceEncadrement();
        $seance8->setDate(new \DateTime('2024-02-15 09:30:00'))
            ->setCommentaire('Cybersecurity internship orientation. Introduced security frameworks and tools. Student shows strong interest.')
            ->setEtudiant($student7)
            ->setSupervisor($supervisor3);
        $manager->persist($seance8);

        $seance9 = new SeanceEncadrement();
        $seance9->setDate(new \DateTime('2024-03-15 16:00:00'))
            ->setCommentaire('Security assessment project review. Student identified critical vulnerabilities and proposed solutions.')
            ->setEtudiant($student7)
            ->setSupervisor($supervisor3);
        $manager->persist($seance9);

        // Additional seances for more variety
        $seance10 = new SeanceEncadrement();
        $seance10->setDate(new \DateTime('2024-05-01 14:00:00'))
            ->setCommentaire('Final project presentation preparation. Student ready for final evaluation with excellent work quality.')
            ->setEtudiant($student1)
            ->setSupervisor($supervisor1);
        $manager->persist($seance10);

        $manager->flush();
    }
}