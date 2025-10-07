<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Journal;
use App\Models\Category;
use App\Models\Author;
use App\Models\Article;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);

        // Admin User - Ayub
        User::factory()->create([
            'name' => 'Ayub',
            'email' => 'ayub@gmail.com',
            'username' => 'ayub',
            'password' => bcrypt('123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Seed Journals
        $journals = [
            [
                'name' => 'International Journal of Medical Research',
                'issn' => '2456-7890',
                'description' => 'A peer-reviewed journal publishing original research in medical sciences',
                'status' => 'active',
            ],
            [
                'name' => 'Journal of Computer Science and Technology',
                'issn' => '1234-5678',
                'description' => 'Leading journal in computer science and technology research',
                'status' => 'active',
            ],
            [
                'name' => 'Environmental Science Review',
                'issn' => '9876-5432',
                'description' => 'Advances in environmental science and sustainability research',
                'status' => 'active',
            ],
            [
                'name' => 'Journal of Business and Economics',
                'issn' => '3456-7891',
                'description' => 'Research in business management and economic studies',
                'status' => 'active',
            ],
            [
                'name' => 'Advanced Materials Research',
                'issn' => '5678-1234',
                'description' => 'Cutting-edge research in materials science and engineering',
                'status' => 'active',
            ],
        ];

        foreach ($journals as $journal) {
            Journal::create($journal);
        }

        // Seed Categories
        $categories = [
            ['name' => 'Medical Sciences', 'description' => 'Research in medical and health sciences'],
            ['name' => 'Computer Science', 'description' => 'Research in computing, AI, and software engineering'],
            ['name' => 'Environmental Studies', 'description' => 'Research in environment, ecology, and climate'],
            ['name' => 'Business & Economics', 'description' => 'Research in business, management, and economics'],
            ['name' => 'Engineering', 'description' => 'Research in various engineering disciplines'],
            ['name' => 'Social Sciences', 'description' => 'Research in sociology, psychology, and anthropology'],
            ['name' => 'Physics & Mathematics', 'description' => 'Research in theoretical and applied sciences'],
            ['name' => 'Chemistry', 'description' => 'Research in organic, inorganic, and analytical chemistry'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Seed Authors
        $authors = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@university.edu',
                'affiliation' => 'Harvard Medical School',
                'specialization' => 'Cardiology',
                'orcid_id' => '0000-0001-2345-6789',
                'author_contributions' => 'Conceived and designed the study, performed data analysis, wrote the manuscript',
            ],
            [
                'name' => 'Prof. Michael Chen',
                'email' => 'michael.chen@mit.edu',
                'affiliation' => 'Massachusetts Institute of Technology',
                'specialization' => 'Artificial Intelligence',
                'orcid_id' => '0000-0002-3456-7890',
                'author_contributions' => 'Developed the algorithm, conducted experiments, reviewed and edited the manuscript',
            ],
            [
                'name' => 'Dr. Emily Rodriguez',
                'email' => 'emily.rodriguez@stanford.edu',
                'affiliation' => 'Stanford University',
                'specialization' => 'Environmental Science',
                'orcid_id' => '0000-0003-4567-8901',
                'author_contributions' => 'Field data collection, statistical analysis, manuscript preparation',
            ],
            [
                'name' => 'Dr. James Wilson',
                'email' => 'james.wilson@oxford.ac.uk',
                'affiliation' => 'Oxford University',
                'specialization' => 'Economics',
                'orcid_id' => '0000-0004-5678-9012',
                'author_contributions' => 'Economic modeling, data interpretation, critical revision of the manuscript',
            ],
            [
                'name' => 'Prof. Lisa Anderson',
                'email' => 'lisa.anderson@caltech.edu',
                'affiliation' => 'California Institute of Technology',
                'specialization' => 'Materials Engineering',
                'orcid_id' => '0000-0005-6789-0123',
                'author_contributions' => 'Material synthesis, characterization, manuscript writing and review',
            ],
            [
                'name' => 'Dr. Ahmed Hassan',
                'email' => 'ahmed.hassan@cambridge.ac.uk',
                'affiliation' => 'Cambridge University',
                'specialization' => 'Neuroscience',
                'orcid_id' => '0000-0006-7890-1234',
                'author_contributions' => 'Experimental design, neuroimaging analysis, manuscript editing',
            ],
            [
                'name' => 'Dr. Maria Garcia',
                'email' => 'maria.garcia@yale.edu',
                'affiliation' => 'Yale University',
                'specialization' => 'Molecular Biology',
                'orcid_id' => '0000-0007-8901-2345',
                'author_contributions' => 'Laboratory experiments, data collection, contributed to manuscript writing',
            ],
            [
                'name' => 'Prof. David Thompson',
                'email' => 'david.thompson@princeton.edu',
                'affiliation' => 'Princeton University',
                'specialization' => 'Quantum Physics',
                'orcid_id' => '0000-0008-9012-3456',
                'author_contributions' => 'Theoretical framework, mathematical modeling, manuscript preparation',
            ],
            [
                'name' => 'Dr. Yuki Tanaka',
                'email' => 'yuki.tanaka@tokyo.ac.jp',
                'affiliation' => 'University of Tokyo',
                'specialization' => 'Robotics',
                'orcid_id' => '0000-0009-0123-4567',
                'author_contributions' => 'Robot design, programming, experimental validation, co-wrote the manuscript',
            ],
            [
                'name' => 'Dr. Rachel Green',
                'email' => 'rachel.green@cornell.edu',
                'affiliation' => 'Cornell University',
                'specialization' => 'Sustainable Agriculture',
                'orcid_id' => '0000-0010-1234-5678',
                'author_contributions' => 'Field studies, soil analysis, manuscript writing and revision',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

        // Seed Articles
        $articles = [
            [
                'title' => 'Novel Approaches to Cardiovascular Disease Treatment Using Gene Therapy',
                'journal_id' => 1,
                'author_id' => 1,
                'category_id' => 1,
                'manuscript_type' => 'Research Article',
                'abstract' => 'This study explores innovative gene therapy techniques for treating cardiovascular diseases. We conducted a comprehensive analysis of 500 patients over a 3-year period, demonstrating significant improvements in cardiac function. The results indicate that targeted gene therapy could revolutionize treatment protocols for heart disease patients.',
                'word_count' => 5800,
                'number_of_tables' => 4,
                'number_of_figures' => 6,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'published',
            ],
            [
                'title' => 'Machine Learning Algorithms for Predictive Analytics in Healthcare Systems',
                'journal_id' => 2,
                'author_id' => 2,
                'category_id' => 2,
                'manuscript_type' => 'Research Article',
                'abstract' => 'We present a novel machine learning framework that improves predictive analytics in healthcare. Our algorithm achieved 94% accuracy in predicting patient outcomes, outperforming existing models by 12%. This research demonstrates the potential of AI in transforming healthcare decision-making processes.',
                'word_count' => 6200,
                'number_of_tables' => 5,
                'number_of_figures' => 8,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'published',
            ],
            [
                'title' => 'Impact of Climate Change on Coastal Ecosystems: A 10-Year Study',
                'journal_id' => 3,
                'author_id' => 3,
                'category_id' => 3,
                'manuscript_type' => 'Research Article',
                'abstract' => 'This longitudinal study examines the effects of climate change on coastal ecosystems over a decade. We analyzed biodiversity changes, water quality metrics, and ecosystem resilience. Our findings reveal significant alterations in species composition and highlight urgent conservation needs.',
                'word_count' => 7500,
                'number_of_tables' => 6,
                'number_of_figures' => 10,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'accepted',
            ],
            [
                'title' => 'Economic Impacts of Digital Transformation in Small and Medium Enterprises',
                'journal_id' => 4,
                'author_id' => 4,
                'category_id' => 4,
                'manuscript_type' => 'Research Article',
                'abstract' => 'This research investigates how digital transformation affects the economic performance of SMEs. Using econometric models and data from 1,000 companies, we demonstrate that digital adoption increases revenue by 23% on average. The study provides actionable insights for business leaders.',
                'word_count' => 5400,
                'number_of_tables' => 7,
                'number_of_figures' => 5,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'No',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'under_review',
            ],
            [
                'title' => 'Advanced Nanomaterials for Energy Storage Applications',
                'journal_id' => 5,
                'author_id' => 5,
                'category_id' => 5,
                'manuscript_type' => 'Research Article',
                'abstract' => 'We present breakthrough developments in nanomaterial engineering for energy storage. Our synthesized materials demonstrate 3x higher capacity than conventional lithium-ion batteries. This advancement could significantly impact renewable energy storage and electric vehicle technology.',
                'word_count' => 6800,
                'number_of_tables' => 3,
                'number_of_figures' => 9,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'published',
            ],
            [
                'title' => 'Neuroplasticity and Cognitive Recovery Following Traumatic Brain Injury',
                'journal_id' => 1,
                'author_id' => 6,
                'category_id' => 1,
                'manuscript_type' => 'Review Article',
                'abstract' => 'This comprehensive review examines recent advances in understanding neuroplasticity mechanisms in TBI recovery. We synthesize findings from 150 studies, identifying key therapeutic targets and rehabilitation strategies that promote cognitive recovery.',
                'word_count' => 8200,
                'number_of_tables' => 2,
                'number_of_figures' => 4,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'revision_required',
            ],
            [
                'title' => 'CRISPR-Cas9 Applications in Cancer Research: Current Progress and Future Directions',
                'journal_id' => 1,
                'author_id' => 7,
                'category_id' => 1,
                'manuscript_type' => 'Research Article',
                'abstract' => 'This study explores the application of CRISPR-Cas9 gene editing technology in cancer treatment. We successfully targeted oncogenes in three different cancer cell lines, achieving up to 85% reduction in tumor growth. Our results suggest promising therapeutic applications.',
                'word_count' => 6500,
                'number_of_tables' => 4,
                'number_of_figures' => 7,
                'previously_submitted' => 'Yes',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'submitted',
            ],
            [
                'title' => 'Quantum Computing: Breaking Classical Encryption Paradigms',
                'journal_id' => 2,
                'author_id' => 8,
                'category_id' => 7,
                'manuscript_type' => 'Research Article',
                'abstract' => 'We demonstrate a quantum algorithm capable of factoring large numbers exponentially faster than classical methods. This breakthrough has significant implications for cryptography and cybersecurity. Our 72-qubit quantum processor successfully factored 2048-bit numbers.',
                'word_count' => 7100,
                'number_of_tables' => 3,
                'number_of_figures' => 6,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'under_review',
            ],
            [
                'title' => 'Autonomous Navigation Systems Using Deep Reinforcement Learning',
                'journal_id' => 2,
                'author_id' => 9,
                'category_id' => 2,
                'manuscript_type' => 'Research Article',
                'abstract' => 'This paper presents a deep reinforcement learning approach for autonomous robot navigation in dynamic environments. Our system achieved 98% success rate in obstacle avoidance and path planning, surpassing state-of-the-art methods by 15%.',
                'word_count' => 5900,
                'number_of_tables' => 5,
                'number_of_figures' => 8,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'accepted',
            ],
            [
                'title' => 'Sustainable Agriculture Practices: Enhancing Soil Health and Crop Yield',
                'journal_id' => 3,
                'author_id' => 10,
                'category_id' => 3,
                'manuscript_type' => 'Research Article',
                'abstract' => 'We conducted a 5-year field study examining sustainable farming techniques impact on soil health and productivity. Results show that integrated crop-livestock systems increased yields by 32% while improving soil organic matter by 45%, demonstrating viability of sustainable agriculture.',
                'word_count' => 6300,
                'number_of_tables' => 6,
                'number_of_figures' => 9,
                'previously_submitted' => 'No',
                'funded_by_outside_source' => 'Yes',
                'confirm_not_published_elsewhere' => 'Yes',
                'confirm_prepared_as_per_guidelines' => 'Yes',
                'status' => 'published',
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
