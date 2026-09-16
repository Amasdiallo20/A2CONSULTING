<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $web = $this->category('Développement Web', 'course', 1);
        $marketing = $this->category('Marketing Digital', 'course', 2);
        $projet = $this->category('Gestion de Projet', 'course', 3);
        $data = $this->category('Data et Excel', 'course', 4);
        $compta = $this->category('Comptabilité', 'course', 5);
        $anglais = $this->category('Anglais', 'course', 6);

        $teacher1 = $this->teacher([
            'name' => 'Jean Dupont',
            'title' => 'Expert en Développement Web',
            'position' => 'Formateur Senior',
            'bio' => 'Plus de 10 ans d\'expérience dans le développement web et les technologies modernes.',
            'email' => 'jean.dupont@a2consulting.com',
            'image' => 'images/teachers/t-1.jpg',
            'is_featured' => true,
        ]);

        $teacher2 = $this->teacher([
            'name' => 'Marie Martin',
            'title' => 'Spécialiste Marketing Digital',
            'position' => 'Consultante Marketing',
            'bio' => 'Experte en stratégie marketing digitale et réseaux sociaux.',
            'email' => 'marie.martin@a2consulting.com',
            'image' => 'images/teachers/t-2.jpg',
            'is_featured' => true,
        ]);

        $teacher3 = $this->teacher([
            'name' => 'Pierre Durand',
            'title' => 'Chef de Projet Certifié',
            'position' => 'Gestionnaire de Projet',
            'bio' => 'Certifié PMP avec une expertise en gestion de projet agile.',
            'email' => 'pierre.durand@a2consulting.com',
            'image' => 'images/teachers/t-3.jpg',
            'is_featured' => false,
        ]);

        $teacher4 = $this->teacher([
            'name' => 'Sophie Bernard',
            'title' => 'Analyste Data',
            'position' => 'Formatrice Excel & BI',
            'bio' => 'Spécialiste de l\'analyse de données, d\'Excel avancé et de Power BI.',
            'email' => 'sophie.bernard@a2consulting.com',
            'image' => 'images/teachers/t-4.jpg',
            'is_featured' => true,
        ]);

        $teacher5 = $this->teacher([
            'name' => 'Fatou N\'Guessan',
            'title' => 'Expert-comptable formatrice',
            'position' => 'Formatrice Comptabilité & Fiscalité',
            'bio' => 'Experte-comptable avec une solide expérience en formation des équipes finance et des entrepreneurs.',
            'email' => 'fatou.nguessan@a2consulting.com',
            'image' => 'images/teachers/t-5.jpg',
            'is_featured' => true,
        ]);

        $teacher6 = $this->teacher([
            'name' => 'James Okonkwo',
            'title' => 'Formateur d\'anglais des affaires',
            'position' => 'Formateur Langues',
            'bio' => 'Enseignant d\'anglais professionnel, TOEIC et communication en entreprise.',
            'email' => 'james.okonkwo@a2consulting.com',
            'image' => 'images/teachers/t-6.jpg',
            'is_featured' => true,
        ]);

        $courses = [
            [
                'title' => 'Formation Complète en PHP et Laravel',
                'description' => 'Apprenez à développer des applications web modernes avec PHP et le framework Laravel.',
                'content' => '<p>Cette formation complète vous permettra de maîtriser PHP et Laravel.</p><ul><li>Introduction à PHP</li><li>Fondamentaux de Laravel</li><li>Eloquent ORM</li><li>Authentification</li><li>API REST</li></ul>',
                'image' => 'images/course/cu-1.jpg',
                'price' => 299,
                'price_type' => 'paid',
                'duration' => '40 heures',
                'teacher_id' => $teacher1->id,
                'category_id' => $web->id,
                'lessons_count' => 25,
                'quizzes_count' => 5,
                'is_featured' => true,
            ],
            [
                'title' => 'Marketing Digital et Réseaux Sociaux',
                'description' => 'Maîtrisez les stratégies de marketing digital et les réseaux sociaux.',
                'content' => '<p>Formation complète sur le marketing digital.</p><ul><li>Stratégie digitale</li><li>Réseaux sociaux</li><li>Publicité en ligne</li><li>SEO</li><li>Email marketing</li></ul>',
                'image' => 'images/course/cu-2.jpg',
                'price' => 199,
                'price_type' => 'paid',
                'duration' => '30 heures',
                'teacher_id' => $teacher2->id,
                'category_id' => $marketing->id,
                'lessons_count' => 20,
                'quizzes_count' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'Gestion de Projet Agile et Scrum',
                'description' => 'Apprenez les méthodologies agiles et Scrum pour piloter vos projets.',
                'content' => '<p>Formation pratique sur Scrum et l\'agilité.</p><ul><li>Méthodes agiles</li><li>Rôles Scrum</li><li>Sprints et cérémonies</li><li>Outils de suivi</li></ul>',
                'image' => 'images/course/cu-3.jpg',
                'price' => 249,
                'price_type' => 'paid',
                'duration' => '35 heures',
                'teacher_id' => $teacher3->id,
                'category_id' => $projet->id,
                'lessons_count' => 22,
                'quizzes_count' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Introduction au JavaScript Moderne',
                'description' => 'Découvrez JavaScript ES6+ et les bases des frameworks front-end.',
                'content' => '<p>JavaScript moderne pour le web interactif.</p><ul><li>ES6+</li><li>DOM</li><li>Promesses</li><li>Introduction à React</li></ul>',
                'image' => 'images/course/cu-4.jpg',
                'price' => 0,
                'price_type' => 'free',
                'duration' => '25 heures',
                'teacher_id' => $teacher1->id,
                'category_id' => $web->id,
                'lessons_count' => 18,
                'quizzes_count' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'SEO et Référencement Naturel',
                'description' => 'Améliorez la visibilité de votre site sur les moteurs de recherche.',
                'content' => '<p>Les fondamentaux du SEO.</p><ul><li>Mots-clés</li><li>On-page</li><li>Netlinking</li><li>Analytics</li></ul>',
                'image' => 'images/course/cu-5.jpg',
                'price' => 179,
                'price_type' => 'paid',
                'duration' => '20 heures',
                'teacher_id' => $teacher2->id,
                'category_id' => $marketing->id,
                'lessons_count' => 15,
                'quizzes_count' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Excel avancé et tableaux de bord',
                'description' => 'Passez d\'Excel basique à des tableaux de bord professionnels.',
                'content' => '<p>Excel pour l\'analyse et le reporting.</p><ul><li>Formules avancées</li><li>TCD</li><li>Power Query</li><li>Tableaux de bord</li></ul>',
                'image' => 'images/course/cu-2.jpg',
                'price' => 159,
                'price_type' => 'paid',
                'duration' => '18 heures',
                'teacher_id' => $teacher4->id,
                'category_id' => $data->id,
                'lessons_count' => 14,
                'quizzes_count' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Power BI : analyse de données',
                'description' => 'Créez des rapports interactifs et des indicateurs de performance avec Power BI.',
                'content' => '<p>Initiation à Power BI Desktop.</p><ul><li>Modèle de données</li><li>DAX de base</li><li>Visuels</li><li>Publication</li></ul>',
                'image' => 'images/course/cu-3.jpg',
                'price' => 229,
                'price_type' => 'paid',
                'duration' => '24 heures',
                'teacher_id' => $teacher4->id,
                'category_id' => $data->id,
                'lessons_count' => 16,
                'quizzes_count' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'Cybersécurité pour les PME',
                'description' => 'Protégez votre organisation : bonnes pratiques, mots de passe, sauvegardes et sensibilisation.',
                'content' => '<p>Les bases de la sécurité informatique en entreprise.</p><ul><li>Risques courants</li><li>Mots de passe et MFA</li><li>Sauvegardes</li><li>Sensibilisation des équipes</li></ul>',
                'image' => 'images/course/cu-1.jpg',
                'price' => 189,
                'price_type' => 'paid',
                'duration' => '16 heures',
                'teacher_id' => $teacher1->id,
                'category_id' => $web->id,
                'lessons_count' => 12,
                'quizzes_count' => 2,
                'is_featured' => false,
            ],
            [
                'title' => 'Comptabilité générale : les fondamentaux',
                'description' => 'Comprendre le bilan, le compte de résultat et les écritures courantes d\'une entreprise.',
                'content' => '<p>Formation de base en comptabilité générale.</p><ul><li>Plan comptable</li><li>Journal et grand livre</li><li>TVA</li><li>Clôture simple</li></ul>',
                'image' => 'images/course/cu-2.jpg',
                'price' => 219,
                'price_type' => 'paid',
                'duration' => '28 heures',
                'teacher_id' => $teacher5->id,
                'category_id' => $compta->id,
                'lessons_count' => 18,
                'quizzes_count' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'Comptabilité analytique et contrôle de gestion',
                'description' => 'Calculez vos coûts, suivez vos marges et pilotez la performance.',
                'content' => '<p>Du coût de revient au tableau de bord financier.</p><ul><li>Coûts complets et partiels</li><li>Budgets</li><li>Écarts</li><li>Indicateurs</li></ul>',
                'image' => 'images/course/cu-3.jpg',
                'price' => 249,
                'price_type' => 'paid',
                'duration' => '24 heures',
                'teacher_id' => $teacher5->id,
                'category_id' => $compta->id,
                'lessons_count' => 16,
                'quizzes_count' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Fiscalité des entreprises (SYSCOHADA)',
                'description' => 'TVA, IS, déclarations et obligations fiscales au quotidien.',
                'content' => '<p>Les bases fiscales pour dirigeants, assistants et comptables.</p><ul><li>TVA</li><li>Impôt sur les sociétés</li><li>Calendrier fiscal</li><li>Pièces justificatives</li></ul>',
                'image' => 'images/course/cu-5.jpg',
                'price' => 199,
                'price_type' => 'paid',
                'duration' => '20 heures',
                'teacher_id' => $teacher5->id,
                'category_id' => $compta->id,
                'lessons_count' => 14,
                'quizzes_count' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Anglais général : niveau débutant',
                'description' => 'Acquérir les bases pour se présenter, comprendre et échanger au quotidien.',
                'content' => '<p>Cours communicatif centré sur l\'oral et le vocabulaire essentiel.</p><ul><li>Prononciation</li><li>Présentation</li><li>Situations courantes</li><li>Grammaire de base</li></ul>',
                'image' => 'images/course/cu-4.jpg',
                'price' => 149,
                'price_type' => 'paid',
                'duration' => '30 heures',
                'teacher_id' => $teacher6->id,
                'category_id' => $anglais->id,
                'lessons_count' => 20,
                'quizzes_count' => 5,
                'is_featured' => false,
            ],
            [
                'title' => 'Business English : anglais professionnel',
                'description' => 'Réunions, e-mails, présentations et négociations en anglais.',
                'content' => '<p>Anglais des affaires pour cadres et équipes commerciales.</p><ul><li>E-mails professionnels</li><li>Réunions</li><li>Présentations</li><li>Téléphone</li></ul>',
                'image' => 'images/course/cu-1.jpg',
                'price' => 229,
                'price_type' => 'paid',
                'duration' => '32 heures',
                'teacher_id' => $teacher6->id,
                'category_id' => $anglais->id,
                'lessons_count' => 22,
                'quizzes_count' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'Préparation TOEIC',
                'description' => 'Entraînement ciblé Listening & Reading pour viser un score TOEIC professionnel.',
                'content' => '<p>Méthodologie, chronomètre et examens blancs.</p><ul><li>Stratégies Listening</li><li>Stratégies Reading</li><li>Vocabulaire d\'entreprise</li><li>Examens blancs</li></ul>',
                'image' => 'images/course/cu-2.jpg',
                'price' => 189,
                'price_type' => 'paid',
                'duration' => '24 heures',
                'teacher_id' => $teacher6->id,
                'category_id' => $anglais->id,
                'lessons_count' => 16,
                'quizzes_count' => 6,
                'is_featured' => false,
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['slug' => Str::slug($course['title'])],
                array_merge($course, [
                    'slug' => Str::slug($course['title']),
                    'students_count' => 0,
                    'is_active' => true,
                ])
            );
        }
    }

    private function category(string $name, string $type, int $order): Category
    {
        return Category::firstOrCreate(
            ['slug' => Str::slug($name)],
            [
                'name' => $name,
                'type' => $type,
                'is_active' => true,
                'order' => $order,
            ]
        );
    }

    private function teacher(array $data): Teacher
    {
        return Teacher::firstOrCreate(
            ['email' => $data['email']],
            array_merge($data, [
                'slug' => Str::slug($data['name']),
                'is_active' => true,
            ])
        );
    }
}
