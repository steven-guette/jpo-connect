import { Link } from 'react-router-dom'
import { Text, Title } from '@mantine/core'
import BodySection from '../atoms/Containers/BodySection'
import PrimaryButton from '../atoms/Buttons/PrimaryButton'

const HeroBanner = () => (
    <BodySection
        bg='laplateforme.8'
        py={80}
        px='xl'
        style={{
            textAlign: 'center',
            color: 'white',
            backgroundImage: 'linear-gradient(135deg, #0362FF 0%, #004BBB 100%)'
        }}
    >

        <Text fz="xs" tt="uppercase" c="laplateforme.2" mb="xs">
            Portail officiel
        </Text>

        <Title order={1} fz={40}>
            Plongez dans l’univers du Numérique
        </Title>

        <Text fz='lg' mt='md'>
            Inscrivez-vous aux Journées Portes Ouvertes de <strong>La Plateforme</strong>
        </Text>

        <PrimaryButton mt='xl' component={Link} to='/event'>
            Découvrir les prochaines dates
        </PrimaryButton>

    </BodySection>
)

export default HeroBanner