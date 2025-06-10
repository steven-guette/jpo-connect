import { Grid, Center, Text } from '@mantine/core'
import LocationCard from './LocationCard.jsx'

const LocationItems = ({ locations }) => {

  if (!locations || locations.length === 0) {
    return (
        <Center py="xl">
            <Text size="lg" c="grayblue.6" fw={500}>
                Aucune localisation disponible pour le moment.
            </Text>
        </Center>
    );
  }

  return (
    <Grid gutter="lg">
        {locations.map((loc) => (
            <Grid.Col key={loc.id} span={{ base: 12, sm: 6, md: 6 }}>
                <LocationCard
                    gpsCoordinates={loc.gpsCoordinates}
                    city={loc.city}
                    streetNumber={loc.streetNumber}
                    streetName={loc.streetName}
                    zipCode={loc.zipCode}
                />
            </Grid.Col>
        ))}
    </Grid>
  );
}

export default LocationItems;