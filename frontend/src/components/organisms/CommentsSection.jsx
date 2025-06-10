import { useEffect, useState, useCallback } from 'react'
import { IconMessageCircle } from '@tabler/icons-react'

import {
    Stack, Group, Text, Paper, Divider, Title, Loader, Avatar, Badge, Button
} from '@mantine/core'

import CommentsService from '../../services/CommentsService'
import Notifications from '../../utils/Notifications'

import ModalManager from '../../utils/ModalManager'
import FormModal from '../atoms/Modals/FormModal'
import CommentForm from '../organisms/CommentForm'

import dayjs from 'dayjs'
import 'dayjs/locale/fr'

dayjs.locale('fr')

const CommentsSection = ({ eventId, roleColors }) => {
    const [comments, setComments] = useState([]);
    const [loading, setLoading] = useState(true);

    const commentModal = ModalManager();

    const refreshComments = useCallback(async () => {
        setLoading(true)
        try {
            const commentsData = await CommentsService.getAll({ jpo_event_fk: eventId })
            if (commentsData.success) {
                setComments(Object.values(commentsData.data));
            } else {
                Notifications.Warning("Les commentaires n'ont pas pu être chargés.")
                console.error(commentsData.errors);
            }
        } catch (err) {
            Notifications.Error("Erreur lors du chargement des commentaires.");
            console.error(err.message);
        } finally {
            setLoading(false);
        }
    }, [eventId])

    useEffect(() => {
        refreshComments();
    }, [refreshComments]);

    return (
        <>
            <Divider my="xl" />

            <Group position="right" my="md">
                <Button onClick={commentModal.open} color="laplateforme.5" size="sm">
                    Ajouter un commentaire
                </Button>
            </Group>

            <FormModal opened={commentModal.opened} onClose={commentModal.close}>
                <CommentForm
                    eventId={eventId}
                    onSuccess={async () => {
                        commentModal.close()
                        await refreshComments()
                    }}
                />
            </FormModal>

            <Group mb="xs" spacing="xs">
                <IconMessageCircle size={20} />
                <Title order={4}>Commentaires</Title>
            </Group>

            {loading ? (
                <Loader color="laplateforme.5" size="sm" />
            ) : comments.length === 0 ? (
                <Text c="dimmed" size="sm">Aucun commentaire pour le moment.</Text>
            ) : (
                <Stack spacing="sm">
                    {comments.map((comment, idx) => (
                        <Paper
                            key={idx}
                            withBorder
                            radius="md"
                            p="md"
                            shadow="xs"
                            sx={{
                                transition: 'box-shadow 0.2s ease, transform 0.2s ease',
                                '&:hover': {
                                    boxShadow: 'sm',
                                    transform: 'translateY(-2px)'
                                }
                            }}
                        >
                            <Group align="center" spacing="xs">
                                <Avatar radius="xl" size="sm" color="laplateforme.5">
                                    {comment.user.firstname?.[0] || '?'}
                                </Avatar>
                                <Stack spacing={0} style={{ flexGrow: 1 }}>
                                    <Group spacing="xs">
                                        <Text fw={500} size="sm">{comment.user.fullName}</Text>
                                        <Badge
                                            size="xs"
                                            variant="light"
                                            color={roleColors[comment.user.roleId - 1] || 'gray'}
                                            tt="capitalize"
                                        >
                                            {comment.user.roleName}
                                        </Badge>
                                    </Group>
                                    <Text size="xs" c="gray">
                                        {dayjs(comment.createdAt).format('D MMM YYYY à HH:mm')}
                                    </Text>
                                </Stack>
                            </Group>
                            <Text mt="sm" size="sm" style={{ whiteSpace: 'pre-line' }}>
                                {comment.content}
                            </Text>
                        </Paper>
                    ))}
                </Stack>
            )}
        </>
    )
}

export default CommentsSection