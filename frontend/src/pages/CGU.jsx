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

const CGU = () => (
    <Container size="md" py="xl">
        <PageTitle children="Conditions Générales d’Utilisation" />

        <Text align="center" size="sm" c="grayblue.6" mb="xl">
            Dernière mise à jour : 30 mai 2025
        </Text>

        <SectionDivider />

        <Section title="1. Objet">
            Les présentes Conditions Générales d’Utilisation ont pour objet de définir les modalités d’accès et d’utilisation du site JPO Connect.
        </Section>

        <Section title="2. Acceptation des conditions">
            En naviguant sur ce site, vous acceptez sans réserve les présentes CGU. Si vous ne les acceptez pas, veuillez ne pas utiliser ce service.
        </Section>

        <Section title="3. Accès au site">
            Le site est accessible gratuitement à tout utilisateur disposant d’un accès à Internet. L’accès à certains services peut nécessiter une authentification.
        </Section>

        <Section title="4. Propriété intellectuelle">
            L’ensemble du contenu du site (textes, images, logos, code, etc.) est la propriété exclusive de La Plateforme sauf mention contraire. Toute reproduction est interdite sans autorisation préalable.
        </Section>

        <Section title="5. Responsabilités">
            La Plateforme ne saurait être tenue responsable en cas de dysfonctionnement du site ou d’erreurs dans les informations fournies. L'utilisateur reste responsable de l’utilisation qu’il fait du site.
        </Section>

        <Section title="6. Données personnelles">
            Des données peuvent être collectées pour le bon fonctionnement du site. Pour plus d’informations, veuillez consulter notre politique de confidentialité.
        </Section>

        <Section title="7. Modification des CGU">
            La Plateforme se réserve le droit de modifier à tout moment les présentes CGU. Les utilisateurs sont invités à les consulter régulièrement.
        </Section>

        <Section title="8. Droit applicable">
            Les présentes CGU sont régies par le droit français. Tout litige sera soumis à la juridiction compétente.
        </Section>
    </Container>
)

export default CGU;