import { Title, Text, Card, Group } from '@mantine/core'
import {IconMapPin} from '@tabler/icons-react'

const LocationCard = ({ gpsCoordinates, city, streetNumber, streetName, zipCode }) => {

    const getGoogleMapEmbedUrl = (coords) => {
        const [lat, lng] = coords.split(',').map((c) => c.trim());
        return `https://maps.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
    }

    return (
        <Card
            shadow="sm"
            padding="lg"
            radius="md"
            withBorder
            style={{ height: '100%' }}
        >
            <Group align="flex-start" spacing="md" noWrap>
                <div style={{ flex: '0 0 120px', height: '100px', borderRadius: '8px', overflow: 'hidden' }}>
                    <iframe
                        src={getGoogleMapEmbedUrl(gpsCoordinates)}
                        width="120"
                        height="100"
                        style={{
                            border: 0,
                            pointerEvents: 'none',
                        }}
                        loading="lazy"
                        allowFullScreen=""
                        referrerPolicy="no-referrer-when-downgrade"
                        title={`Carte de ${city}`}
                    />
                </div>

                <div>
                    <Title order={4} c="laplateforme.6">
                        {zipCode} {city}
                    </Title>

                    <Text mt="xs" c="grayblue.8">
                        {streetNumber ? `${streetNumber} ` : ''}
                        {streetName}
                    </Text>

                    <Text
                        component="a"
                        href={`https://www.google.com/maps?q=${encodeURIComponent(gpsCoordinates)}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        mt="sm"
                        size="sm"
                        fw={600}
                        c="laplateforme.6"
                        style={{
                            display: 'inline-flex',
                            alignItems: 'center',
                            gap: '6px',
                            textDecoration: 'none',
                            borderRadius: '6px',
                            padding: '4px 8px',
                            transition: 'background 0.2s ease',
                        }}
                        onMouseOver={(e) => {
                            e.currentTarget.style.background = '#e6f0ff'
                        }}
                        onMouseOut={(e) => {
                            e.currentTarget.style.background = 'transparent'
                        }}
                    >
                        <IconMapPin size={16} stroke={2} />
                        Voir sur la carte
                    </Text>
                </div>
            </Group>
        </Card>
    );
}

export default LocationCard;