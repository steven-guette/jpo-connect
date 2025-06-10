import { useParams } from 'react-router-dom'
import { useEffect, useState } from 'react'
import { useAuth } from '../contexts/AuthContext'

import {
    Container, Title, Text, Image, Group, Stack, Loader,
    Progress, Button, Divider, Center, Alert, Paper, Badge
} from '@mantine/core'

import {
    IconCalendarEvent, IconMapPin, IconUser, IconLogin2,
    IconUserCircle, IconAlertTriangle
} from '@tabler/icons-react'

import EventsService from '../services/EventsService'
import RegistrationsService from '../services/RegistrationsService'
import Notifications from '../utils/Notifications.jsx'

import CommentsSection from '../components/organisms/CommentsSection'

import dayjs from 'dayjs'
import 'dayjs/locale/fr'
dayjs.locale('fr')

const roleColors = [ 'violet', 'blue', 'green', 'gray'];

const EventDetail = () => {
    const { eventId } = useParams();
    const { user, isAuthenticated } = useAuth();

    const [event, setEvent] = useState(null);
    const [registrations, setRegistrations] = useState([]);
    const [userIsRegistered, setUserIsRegistered] = useState(false);
    const [remainingPlaces, setRemainingPlaces] = useState(0);

    const [loading, setLoading] = useState(true);
    const [reserving, setReserving] = useState(false);
    const [isRefresh, setIsRefresh] = useState(false);

    useEffect(() => {
        const fetchEventData = async () => {
            try {
                const eventsData = await EventsService.getOne(eventId);
                const registrationsData = await RegistrationsService.getAll({ jpo_event_fk: eventId });

                console.log('[EventDetail] eventsData:', eventsData)
                console.log('[EventDetail] registrationsData:', registrationsData)

                if (!eventsData.success || !registrationsData.success) {
                    if (!eventsData.success) {
                        Notifications.Error("Une erreur est survenue lors du chargement de l'événement.");
                        console.error(eventsData.errors);
                    } else {
                        Notifications.Error("Une erreur est survenue lors du chargement des des réservations.");
                        console.error(registrationsData.errors);
                    }
                    return;
                }

                setRemainingPlaces(eventsData.data.maxCapacity - eventsData.data.currentRegistered);
                setEvent(eventsData.data);
                setRegistrations(registrationsData.data)
                setUserIsRegistered(isAuthenticated
                    ? registrationsData.data.some(reg => reg.userFk === user.id && reg.canceled === false)
                    : false
                );
            } catch (err) {
                Notifications.Error("Une erreur est survenue lors du chargement des données.");
                console.error(err);
            } finally {
                setLoading(false);
            }
        }
        fetchEventData();
    }, [eventId, isAuthenticated, user])

    const handleRegistration = async () => {
        if (!isAuthenticated) return;
        setReserving(true)

        try {
            let registrationResult;
            if (!userIsRegistered) {
                registrationResult = await RegistrationsService.update(0, {
                    user_fk: user.id,
                    jpo_event_fk: event.id,
                    was_present: true,
                    canceled: false
                });
            } else {
                registrationResult = await RegistrationsService.update(0, {
                    user_fk: user.id,
                    jpo_event_fk: event.id,
                    was_present: false,
                    canceled: true
                });
            }

            if (registrationResult.success) {
                await refreshRegistrations();
                Notifications.Success(userIsRegistered
                    ? `Votre réservation a bien été annulée ${user.firstname}, peut être qu'une autre de nos journées portes ouvertes sera plus adaptée à vos attentes ?`
                    : `Votre réservation a bien été enregistrée ${user.firstname}, nous avons hâte de vous accueillir dans nos locaux de ${event.location.city} !`
                );
            } else if (registrationResult.status === 409) {
                Notifications.Warning(registrationResult.message);
            } else {
                Notifications.Error(userIsRegistered
                    ? "Nous n'avons pas réussi à annuler votre inscription pour cette journée portes ouvertes."
                    : "Nous n'avons pas réussi à vous inscrire pour cette journée portes ouvertes."
                );
                console.error(registrationResult.errors);
            }
        } catch (err) {
            Notifications.Error("Nous ne sommes pas en mesure de traiter votre demande.");
            console.error(err);
        } finally {
            setReserving(false);
        }
    }

    const refreshRegistrations = async () => {
        if (!isAuthenticated) return;
        setIsRefresh(true);

        try {
            const [eventsData, registrationsData] = await Promise.all([
                EventsService.getOne(eventId),
                RegistrationsService.getAll({ jpo_event_fk: eventId })
            ])

            if (!eventsData.success || !registrationsData.success) {
                Notifications.Warning("Une erreur est survenue lors de la mise à jours des données.");
                return;
            }

            setRemainingPlaces(eventsData.data.maxCapacity - eventsData.data.currentRegistered);
            setEvent(eventsData.data);
            setRegistrations(registrationsData.data)
            setUserIsRegistered(registrationsData.data.some(reg => reg.userFk === user.id && reg.canceled === false));
        } catch (err) {
            Notifications.Error("Une erreur est survenue lors de l’actualisation des réservations.");
            console.error(err);
        } finally {
            setIsRefresh(false);
        }
    }

    if (loading) {
        return (
            <Center h="80vh">
                <Loader size={60} color="laplateforme.5" />
            </Center>
        )
    }

    const {
        description, imagePath, startDatetime, endDatetime,
        maxCapacity, currentRegistered, practicalInfo, location
    } = event

    const start = dayjs(startDatetime)
    const end = dayjs(endDatetime)
    const registrationRate = Math.round((currentRegistered / maxCapacity) * 100)

    return (
        <Container size="md" py="xl" style={{ color: '#1A1B1E' }}>
            <Image
                radius="md"
                src={`https://www.whitecat.fr/jpo-connect/images/event_cards/${imagePath}`}
                alt="Illustration de l'événement"
                mb="md"
                withPlaceholder
            />

            <Group position="apart" align="flex-start" mb="xs">
                <Title order={2}>{description}</Title>
            </Group>

            <Divider my="md" />

            <Stack spacing="xs">
                <Group spacing="xs">
                    <IconCalendarEvent size={18} />
                    <Text c="grayblue.8">
                        {start.format('dddd D MMMM YYYY')} de {start.format('HH:mm')} à {end.format('HH:mm')}
                    </Text>
                </Group>

                <Group spacing="xs">
                    <IconMapPin size={18} />
                    <Text c="grayblue.8">
                        {location.streetNumber} {location.streetName}, {location.zipCode} {location.city}
                    </Text>
                </Group>

                <Group spacing="xs">
                    <IconUser size={18} />
                    <Text c="grayblue.8">
                        {currentRegistered} inscrit(s) / {maxCapacity} places
                    </Text>
                    {remainingPlaces<= 10 && (
                        <Badge
                            leftSection={<IconAlertTriangle size={12} />}
                            color={remainingPlaces <= 5 ? "red" : "orange"}
                            variant="light"
                            size="sm"
                        >
                            {remainingPlaces > 0 ? `Il reste ${remainingPlaces} place(s)` : "Complet"}
                        </Badge>
                    )}
                </Group>

                <Progress
                    value={registrationRate}
                    color="laplateforme.5"
                    radius="xl"
                    size="lg"
                    label={`${registrationRate}% rempli`}
                />
            </Stack>

            <Divider my="xl" />

            <Text fw={600} size="md" mb="xs">Infos pratiques :</Text>
            <Text c="grayblue.8">{practicalInfo}</Text>

            <Divider my="xl" />

            <Group position="apart" align="center" mb="xs">
                <Text fw={600} size="md">Liste des inscrits :</Text>
                {isRefresh && <Loader size="xs" color="laplateforme.5" />}
            </Group>
            <Stack spacing="xs">
                {registrations.filter(registration => !registration.canceled).map((registration, i) => (
                    <Paper key={i} shadow="xs" p="sm" withBorder radius="md">
                        <Group position="apart" align="center">
                            <Group spacing="xs">
                                <IconUserCircle size={20} />
                                <Text>{registration.user.fullName}</Text>
                            </Group>
                            <Badge color={roleColors[registration.user.roleId - 1] || 'gray'} variant="light" tt="capitalize">
                                {registration.user.roleName}
                            </Badge>
                        </Group>
                    </Paper>
                ))}
                {registrations.filter(r => !r.canceled).length === 0 && (
                    <Text c="dimmed" size="sm">Aucun inscrit pour le moment.</Text>
                )}
            </Stack>

            <Divider my="xl" />

            {isAuthenticated ? (
                <>
                    {currentRegistered < maxCapacity || userIsRegistered ? (
                        <Button
                            fullWidth
                            size="lg"
                            color={userIsRegistered ? 'danger.5' : 'laplateforme.5'}
                            onClick={handleRegistration}
                            loading={reserving}
                            disabled={!userIsRegistered && currentRegistered >= maxCapacity}
                        >
                            {userIsRegistered ? 'Annuler ma réservation' : 'Réserver ma place'}
                        </Button>
                    ) : (
                        <Alert
                            icon={<IconUser size={18}/>}
                            title="Complet"
                            color="red"
                            mt="md"
                        >
                            Désolé, cette journée portes ouvertes est déjà complète.
                        </Alert>
                    )}
                    <CommentsSection eventId={eventId} roleColors={roleColors} />
                </>
            ) : (
                <Alert
                    icon={<IconLogin2 size={18} />}
                    title="Connectez-vous"
                    color="gray"
                >
                    Vous devez être connecté pour réserver une place à cet événement.
                </Alert>
            )}

        </Container>
    )
}

export default EventDetail;

