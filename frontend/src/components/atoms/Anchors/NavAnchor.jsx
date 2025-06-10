import { Anchor } from '@mantine/core';
import { NavLink } from 'react-router-dom';

const NavAnchor = ({ children, to, ...props }) => (
    <NavLink to={to}>
        {({ isActive }) => (
            <Anchor
                component="span"
                fw={500}
                size="sm"
                c={isActive ? 'laplateforme.6' : 'dark.7'}
                {...props}
            >
                {children}
            </Anchor>
        )}
    </NavLink>
);

export default NavAnchor;