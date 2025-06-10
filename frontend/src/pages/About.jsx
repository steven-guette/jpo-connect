import { Text, Container } from '@mantine/core'

import BodySection from '../components/atoms/Containers/BodySection'
import PageTitle from '../components/atoms/Titles/PageTitle'
import SectionDivider from '../components/atoms/Dividers/SectionDivider'

const About = () => (
    <Container size="md" py="xl">
        <PageTitle style={{ textTransform: 'uppercase' }}>
            Qui sommes-nous ?
        </PageTitle>

        <SectionDivider />

        <BodySection
            bg="#f8f9fc"
            radius="md"
            px="xl"
            py="xl"
            style={{ boxShadow: '0 4px 12px rgba(0, 0, 0, 0.05)' }}
        >
            <Text size="lg" lh="1.8" c="grayblue.8">
                <strong>La Plateforme_</strong> est une école du numérique et des nouvelles technologies co-fondée avec le Club Top 20 réunissant les grandes entreprises de la Métropole Aix Marseille.
                Elle comprend une offre de formations diversifiées destinées à former des développeurs web, logiciels, des experts en sécurité, des ingénieurs spécialisés en Intelligence Artificielle et systèmes immersifs,
                et des cadres d’entreprises au travers de cycles de formations continues.
            </Text>
        </BodySection>

        <BodySection
            bg="#ffffff"
            radius="md"
            px="xl"
            py="xl"
            mt="lg"
            style={{ border: '1px solid #e7edf5' }}
        >
            <Text size="lg" lh="1.8" c="grayblue.9">
                <strong>La Plateforme_</strong> est membre du programme Grande École du Numérique. Elle est soutenue par de grandes entreprises du territoire comme le Crédit Agricole Alpes Provence,
                par la Région Sud, le Département des Bouches du Rhône et la Métropole Aix Marseille Provence.
                Elle est reconnue Établissement d’Enseignement Supérieur Technique Privé de l’académie Provence Alpes Côte d’Azur, enregistré sous le numéro <strong>01344255</strong>.
            </Text>
        </BodySection>
    </Container>
)

export default About