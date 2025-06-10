import { useEffect, useState } from 'react'
import {
    Container, Loader, Center, Text, Group, Badge
} from '@mantine/core'

import EventsService from '../services/EventsService'

import PageTitle from '../components/atoms/Titles/PageTitle'
import EventCard from '../components/organisms/EventCard'
import SectionDivider from '../components/atoms/Dividers/SectionDivider'

const Event = () => {
    const [events, setEvents] = useState([]);
    const [filteredEvents, setFilteredEvents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedCity, setSelectedCity] = useState(null);

    useEffect(() => {
        const fetchEvents = async () => {
            try {
                const eventsData = await EventsService.getAll();
                if (eventsData.success) {
                    setEvents(eventsData.data);
                    setFilteredEvents(eventsData.data);
                }
            } catch (err) {
                console.error("Erreur lors du chargement des événements :", err.message);
            } finally {
                setLoading(false);
            }
        }
        fetchEvents();
    }, []);

    const uniqueCities = [...new Set(events.map(e => e.location?.city).filter(Boolean))];

    const handleFilter = (city) => {
        if (city === selectedCity) {
            setFilteredEvents(events);
            setSelectedCity(null);
        } else {
            setFilteredEvents(events.filter(e => e.location?.city === city));
            setSelectedCity(city);
        }
    }

    if (loading) {
        return (
            <Center py="xl">
                <Loader size="lg" color="laplateforme.5" />
            </Center>
        )
    }

    return (
        <Container size="md" py="xl">
            <PageTitle>Nos Journées Portes Ouvertes</PageTitle>
            <SectionDivider />

            <Group spacing="xs" mt="md" mb="lg" position="center">
                {uniqueCities.map((city, i) => (
                    <Badge
                        key={i}
                        onClick={() => handleFilter(city)}
                        color={selectedCity === city ? "laplateforme.5" : "gray"}
                        variant={selectedCity === city ? "filled" : "light"}
                        style={{ cursor: 'pointer', textTransform: 'capitalize' }}
                    >
                        {city}
                    </Badge>
                ))}
            </Group>

            {filteredEvents.length === 0 ? (
                <Text align="center" color="gray" mt="xl" fz="lg">
                    Aucun événement trouvé pour cette ville.
                </Text>
            ) : (
                filteredEvents.map(event => (
                    <EventCard key={event.id} event={event} />
                ))
            )}
        </Container>
    )
}

export default Event;