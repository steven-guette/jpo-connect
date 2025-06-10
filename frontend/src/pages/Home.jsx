import { Title, Text } from '@mantine/core'

import HeroBanner from '../components/organisms/HeroBanner.jsx'
import SocialBanner from '../components/organisms/SocialBanner'
import BodySection from '../components/atoms/Containers/BodySection'

const Home = () => (
    <>
        <HeroBanner />

        <BodySection bg="grayblue.0" radius="md" mt="xl" style={{ textAlign: 'center' }}>
            <Title order={2} c="laplateforme.6">Pourquoi participer à une JPO ?</Title>
            <Text mt='md'>
                Découvrez nos formations, rencontrez notre équipe, échangez avec les étudiants et explorez les locaux de La Plateforme dans un cadre immersif 100% tech.
            </Text>
        </BodySection>

        <BodySection bg="grayblue.0" radius="md" mt="xl">
            <SocialBanner />
        </BodySection>
    </>
)

export default Home