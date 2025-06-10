import {useEffect, useState} from 'react'
import { Container, Loader, Center } from '@mantine/core'

import LocationsService from '../services/LocationsService'
import LocationItems from '../components/organisms/LocationItems'
import PageTitle from '../components/atoms/Titles/PageTitle'
import SectionDivider from '../components/atoms/Dividers/SectionDivider'

const Location = () => {
    const [locations, setLocations] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchLocations = async () => {
            const locationsData = await LocationsService.getAll();
            if (locationsData.success) {
                setLocations(locationsData.data);
            } else {
                setLocations([]);
                console.error(locationsData.errors);
            }
            setLoading(false);
        }
        fetchLocations();
    }, []);

    return (
        <Container size="lg" py="xl">
            <PageTitle children="Nos campus en France" />
            <SectionDivider />

            {loading ? (
                <Center>
                    <Loader size="lg" color="laplateforme.5" />
                </Center>
            ) : (
                <LocationItems locations={locations} />
            )}
        </Container>
    )
}

export default Location;