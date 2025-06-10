import { useState } from 'react'
import { useAuth } from '../contexts/AuthContext'
import { Container, Text, Group, Card, Stack } from '@mantine/core'

import PrimaryButton from '../components/atoms/Buttons/PrimaryButton'
import SectionDivider from '../components/atoms/Dividers/SectionDivider'
import LogoutButton from '../components/molecules/LogoutButton'
import PageTitle from '../components/atoms/Titles/PageTitle'
import EditProfilForm from '../components/organisms/EditProfilForm'
import EditPasswordForm from '../components/organisms/EditPasswordForm'
import FormModal from '../components/atoms/Modals/FormModal'
import ModalManager from '../utils/ModalManager'

const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}

const Account = () => {
    const passwordModal = ModalManager();
    const { user } = useAuth();

    const [editMode, setEditMode] = useState(false);

    return (
        <Container size="sm" py="xl">
            <PageTitle>Mon espace personnel</PageTitle>
            <SectionDivider />

            <Card withBorder shadow="sm" radius="md" mt="xl" p="lg">
                <Stack spacing="sm">
                    {!editMode ? (
                        <>
                            <Group position="apart">
                                <Text fw={600}>Prénom :</Text>
                                <Text c="grayblue.8">{user.firstname}</Text>
                            </Group>

                            <Group position="apart">
                                <Text fw={600}>Nom :</Text>
                                <Text c="grayblue.8">{user.name}</Text>
                            </Group>

                            <Group position="apart">
                                <Text fw={600}>Email :</Text>
                                <Text c="grayblue.8">{user.email}</Text>
                            </Group>

                            <Group position="apart">
                                <Text fw={600}>Statut :</Text>
                                <Text c="grayblue.8">{user.roleName}</Text>
                            </Group>

                            <Group position="apart">
                                <Text fw={600}>Inscrit le :</Text>
                                <Text c="grayblue.8">{formatDate(user.createdAt)}</Text>
                            </Group>
                        </>
                    ) : (
                        <EditProfilForm onSuccess={() => setEditMode(false)} />
                    )}
                </Stack>
            </Card>

            {!editMode && (
                <>
                    <Group position="center" mt="xl">
                        <PrimaryButton variant="light" onClick={() => setEditMode(true)}>
                            Modifier mes informations
                        </PrimaryButton>

                        <PrimaryButton variant="light" onClick={passwordModal.open}>
                            Modifier mon mot de passe
                        </PrimaryButton>

                        <FormModal opened={passwordModal.opened} onClose={passwordModal.close}>
                            <EditPasswordForm onSuccess={passwordModal.close} />
                        </FormModal>
                    </Group>

                    <Group position="center" mt="xl">
                        <LogoutButton />
                    </Group>
                </>
            )}
        </Container>
    )
}

export default Account