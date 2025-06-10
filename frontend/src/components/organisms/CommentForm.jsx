import { useState } from 'react'
import { Textarea, Group, Stack } from '@mantine/core'
import { useAuth } from '../../contexts/AuthContext'

import CommentsService from '../../services/CommentsService'
import Notifications from '../../utils/Notifications'

import FormTitle from '../atoms/Titles/FormTitle'
import PrimaryButton from '../atoms/Buttons/PrimaryButton'

const CommentForm = ({ eventId, onSuccess }) => {
    const { user, isAuthenticated } = useAuth();
    const [content, setContent] = useState('');
    const [submitting, setSubmitting] = useState(false);

    const handleSubmit = async () => {
        if (!isAuthenticated || !content.trim()) return;
        setSubmitting(true);

        try {
            const commentResult = await CommentsService.create({
                content,
                user_fk: user.id,
                jpo_event_fk: eventId
            });

            if (commentResult.success) {
                Notifications.Success("Votre commentaire a été ajouté avec succès !");
                setContent('');
                onSuccess();
            } else {
                Notifications.Error("Nous ne parvenons pas à ajouter votre commentaire.");
            }
        } catch (err) {
            Notifications.Error("Une erreur est survenue lors de l'ajout de votre commentaire.");
            console.error('[CommentForm] Erreur :', err);
        } finally {
            setSubmitting(false);
        }
    }

    return (
        <Stack>
            <FormTitle>Nouveau commentaire</FormTitle>

            <Textarea
                placeholder="Votre commentaire..."
                autosize
                minRows={4}
                size="md"
                radius="md"
                value={content}
                onChange={(e) => setContent(e.currentTarget.value)}
            />

            <Group position="right">
                <PrimaryButton onClick={handleSubmit} loading={submitting} fullWidth >
                    Publier
                </PrimaryButton>
            </Group>
        </Stack>
    )
}

export default CommentForm;