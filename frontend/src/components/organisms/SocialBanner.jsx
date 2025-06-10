import { Title, Text, Group, Stack } from '@mantine/core'
import {
    IconBrandFacebook,
    IconBrandInstagram,
    IconBrandLinkedin,
    IconBrandTwitter,
    IconBrandYoutube
} from '@tabler/icons-react'

import ActionIcon from '../atoms/Icons/ActionIcon'

const SocialBanner = () => {
    return (
        <Stack align="center" spacing="md" py="xl">
            <Title order={2} c="laplateforme.6">
                Suivez-nous sur les réseaux
            </Title>
            <Text c="grayblue.7" ta="center">
                <strong>Ne manquez rien de l’actualité de La Plateforme : </strong>événements, projets étudiants, moments forts et immersions dans l’univers numérique.
            </Text>

            <Group spacing="lg" mt="sm">
                <ActionIcon href="https://www.facebook.com/LaPlateformeIO">
                    <IconBrandFacebook size={24} />
                </ActionIcon>

                <ActionIcon href="https://www.instagram.com/LaPlateformeIO/">
                    <IconBrandInstagram size={24} />
                </ActionIcon>

                <ActionIcon href="https://www.linkedin.com/school/laplateformeio/">
                    <IconBrandLinkedin size={24} />
                </ActionIcon>

                <ActionIcon href="https://twitter.com/LaPlateformeIO">
                    <IconBrandTwitter size={24} />
                </ActionIcon>

                <ActionIcon href="https://www.youtube.com/c/LaPlateformeIO">
                    <IconBrandYoutube size={24} />
                </ActionIcon>
            </Group>
        </Stack>
    );
}

export default SocialBanner