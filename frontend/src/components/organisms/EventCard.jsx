import { Card, Text, Group, Badge, Progress, Button } from '@mantine/core'
import { useNavigate } from 'react-router-dom'

import PrimaryButton from '../atoms/Buttons/PrimaryButton'

const EventCard = ({ event }) => {
    const navigate = useNavigate();
    const progress = (event.currentRegistered / event.maxCapacity) * 100;

    return (
        <Card withBorder shadow="sm" radius="md" p="md" mb="xl" style={{ overflow: 'hidden', position: 'relative' }}>
            <div style={{ position: 'relative', borderRadius: '8px', overflow: 'hidden' }}>
                <img
                    src={`https://www.whitecat.fr/jpo-connect/images/event_cards/${event.imagePath}`}
                    alt={event.description}
                    style={{ width: '100%', height: '200px', objectFit: 'cover' }}
                />
                <div
                    style={{
                        position: 'absolute',
                        top: 0,
                        left: 0,
                        width: '100%',
                        height: '100%',
                        background: 'linear-gradient(to top, rgba(0,0,0,0.4), rgba(0,0,0,0))',
                    }}
                />
                <Badge
                    color="laplateforme"
                    style={{
                        position: 'absolute',
                        top: '12px',
                        right: '12px',
                        zIndex: 2,
                        fontWeight: 'bold',
                        fontSize: '0.75rem',
                        boxShadow: '0 0 5px rgba(0,0,0,0.25)',
                    }}
                >
                    {event.location.city.toUpperCase()}
                </Badge>
            </div>

            <Group mt="md" position="apart" noWrap>
                <Text fw={600} size="lg" truncate="end">{event.description}</Text>
            </Group>

            <Text size="sm" color="dimmed" mt={5}>
                Le {new Date(event.startDatetime).toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            })} de {event.startDatetime.split(' ')[1].slice(0, 5)} à {event.endDatetime.split(' ')[1].slice(0, 5)}
            </Text>

            <Text size="sm" mt={3}>
                Lieu : {event.location.streetNumber} {event.location.streetName}, {event.location.zipCode} {event.location.city}
            </Text>

            <Text size="sm" mt={3}>
                {event.currentRegistered} inscrit(s) / {event.maxCapacity} places
            </Text>

            <Progress value={progress} mt="xs" size="sm" radius="xs" color="laplateforme" />

            <PrimaryButton
                variant="light"
                color="laplateforme"
                fullWidth
                mt="md"
                radius="md"
                onClick={() => navigate(`/event/${event.id}`)}
            >
                Voir les détails
            </PrimaryButton>
        </Card>
    );
};

export default EventCard;