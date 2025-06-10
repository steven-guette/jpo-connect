import { useState } from 'react'
import { ActionIcon as MantineActionIcon } from '@mantine/core'

const ActionIcon = ({ children, href, ...props }) => {
    const [hovered, setHovered] = useState(false)

    return (
        <MantineActionIcon
            size="lg"
            variant="light"
            color="grayblue"
            component="a"
            href={href}
            target="_blank"
            onMouseEnter={() => setHovered(true)}
            onMouseLeave={() => setHovered(false)}
            style={{
                transition: 'transform 0.3s ease, background-color 0.3s ease',
                transform: hovered ? 'rotate(360deg)' : 'rotate(0deg)',
                backgroundColor: hovered ? '#013399' : 'transparent',
                color: hovered ? '#fff' : '#394c8d',
                borderRadius: '50%',
            }}
            {...props}
        >
            {children}
        </MantineActionIcon>
    )
};

export default ActionIcon;