<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'create-user';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserPasswordEncoderInterface */
    private $requirePasswordEncoder;

    public function __construct(EntityManagerInterface $entityManager,UserPasswordEncoderInterface $requirePasswordEncoder)
    {
        $this->entityManager = $entityManager;

        $this->requirePasswordEncoder = $requirePasswordEncoder;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
        $username = $input->getArgument('username');
        $helper = $this->getHelper('question');
        $question = new Question(sprintf("Hello bro, mdp plz".PHP_EOL,$username));
        $question->setHidden(true);
        $password = $helper->ask($input,$output,$question);

        $user = new User();
        $user
            ->setUsername($username)
            ->setPassword($this->requirePasswordEncoder->encodePassword($user,$password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $output->writeln('User successfully generated!');

        return 0;
    }
}
