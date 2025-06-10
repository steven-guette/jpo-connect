import { Container, Title, Text, Group, Stack, Textarea, Button, Paper } from '@mantine/core'
import { IconPhone, IconMapPin, IconSend } from '@tabler/icons-react'
import FormTitle from '../components/atoms/Titles/FormTitle'
import TextInput from '../components/atoms/Inputs/TextInput'

const Contact = () => {
    return (
        <Container size="md" py="xl">
            <Title order={2} mb="sm">Contactez-nous</Title>
            <Text c="dimmed" mb="md" c="grayblue.8">
                Vous avez une question ? Une demande particulière ? N'hésitez pas à nous contacter, notre équipe vous répondra dans les plus brefs délais.
            </Text>

            <Paper shadow="xs" p="lg" withBorder radius="md">
                <Stack spacing="md">
                    <Group spacing="xl" align="flex-start" mb="sm" style={{ color: '#000', fontWeight: 700 }}>
                        <Group spacing="xs">
                            <IconPhone size={20} />
                            <Text>Téléphone : 04.84.89.43.69</Text>
                        </Group>
                        <Group spacing="xs">
                            <IconMapPin size={20} />
                            <Text>8 rue d’Hozier, 13002 Marseille</Text>
                        </Group>
                    </Group>

                    <FormTitle>Formulaire de contact</FormTitle>

                    <TextInput label="Votre nom" placeholder="Jean Dupont" required />
                    <TextInput label="Votre adresse email" placeholder="jean.dupont@email.com" required />
                    <Textarea
                        label="Votre message"
                        labelProps={{ style: { color: '#000', fontWeight: 700 } }}
                        placeholder="Bonjour, je souhaiterais obtenir des informations..."
                        minRows={4}
                        required
                    />

                    <Button leftIcon={<IconSend size={18} />} disabled>
                        Envoyer
                    </Button>
                </Stack>
            </Paper>
        </Container>
    )
}

export default Contact