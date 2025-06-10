import { Container, Title, Text, Button, Center, Stack } from '@mantine/core'
import { IconArrowLeft } from '@tabler/icons-react'
import { Link } from 'react-router-dom'
import { motion } from 'framer-motion'

const MotionTitle = motion(Title)
const MotionText = motion(Text)
const MotionButton = motion(Button)

const NotFound = () => {
    return (
        <Container size="md" py="xl">
            <Center style={{ minHeight: '70vh' }}>
                <Stack align="center" spacing="lg">
                    <MotionTitle
                        order={1}
                        initial={{ scale: 0.8, opacity: 0 }}
                        animate={{ scale: 1, opacity: 1 }}
                        transition={{ duration: 0.4, ease: 'easeOut' }}
                        style={{
                            fontSize: '6rem',
                            fontWeight: 900,
                            color: '#013399',
                            letterSpacing: '-0.05em',
                            textShadow: '0 0 10px rgba(3, 98, 255, 0.3)',
                        }}
                    >
                        404
                    </MotionTitle>

                    <MotionText
                        size="lg"
                        align="center"
                        color="grayblue.7"
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: 0.2, duration: 0.5 }}
                    >
                        <strong>T’as hacké l’URL comme un enfant gratte un ticket de loto :</strong> sans talent, sans résultat, mais plein d’espoir.
                    </MotionText>

                    <MotionButton
                        component={Link}
                        to="/home"
                        variant="light"
                        color="laplateforme"
                        leftIcon={<IconArrowLeft size={18} />}
                        initial={{ opacity: 0, y: 10 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: 0.4, duration: 0.4 }}
                        style={{ cursor: "pointer" }}
                    >
                        Retourne gratter ailleurs...
                    </MotionButton>
                </Stack>
            </Center>
        </Container>
    )
}

export default NotFound