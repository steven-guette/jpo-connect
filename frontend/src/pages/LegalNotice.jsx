import { Text, Container } from '@mantine/core'

import BodySection from '../components/atoms/Containers/BodySection'
import PageTitle from '../components/atoms/Titles/PageTitle'
import SectionTitle from '../components/atoms/Titles/SectionTitle'
import SectionDivider from '../components/atoms/Dividers/SectionDivider'

const Section = ({ title, children }) => (
    <BodySection
        bg="#ffffff"
        px="xl"
        py="lg"
        mt="lg"
        radius="md"
        style={{
            border: '1px solid #e7edf5',
        }}
    >
        <SectionTitle children={title} />
        <Text size="md" lh="1.8" c="grayblue.9">
            {children}
        </Text>
    </BodySection>
)

const LegalNotice = () => (
    <Container size="md" py="xl">
        <PageTitle children="Mentions Légales" />

        <Text align="center" size="sm" c="grayblue.6" mb="xl">
            Conformément à la loi n° 2004-575 du 21 juin 2004 pour la confiance dans l’économie numérique.
        </Text>

        <SectionDivider />

        <Section title="1. Éditeur du site">
            Le site <strong>JPO Connect</strong> est édité par <strong>La Plateforme_</strong>, située au 8 Rue d’Hozier, 13002 Marseille, France.
            Numéro SIRET : 01344255000017.
        </Section>

        <Section title="2. Responsable de publication">
            Le responsable de la publication est <strong>La Plateforme_</strong>.
        </Section>

        <Section title="3. Hébergement">
            Le site est hébergé sur une infrastructure privée, administrée par l’équipe de développement de La Plateforme.
            Adresse technique : <em>https://jpo-connect.whitecat.ovh</em>.
        </Section>

        <Section title="4. Propriété intellectuelle">
            Le contenu du site, incluant les textes, visuels, éléments graphiques, et code source, est protégé par les lois en vigueur sur la propriété intellectuelle.
            Toute reproduction ou représentation, intégrale ou partielle, sans autorisation écrite est interdite.
        </Section>

        <Section title="5. Données personnelles">
            Aucune donnée personnelle n’est collectée sans le consentement de l’utilisateur.
            Pour plus de détails, consultez la page dédiée à notre politique de confidentialité.
        </Section>

        <Section title="6. Contact">
            Pour toute question ou réclamation :
            <Text component="span" fw={700}>contact@laplateforme.io</Text>
        </Section>
    </Container>
)

export default LegalNotice