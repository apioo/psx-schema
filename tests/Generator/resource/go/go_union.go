type Creature struct {
    Kind string `json:"kind"`
}

type Human struct {
    Kind string `json:"kind"`
    FirstName string `json:"firstName"`
}

type Animal struct {
    Kind string `json:"kind"`
    Nickname string `json:"nickname"`
}

type Union struct {
    Union any `json:"union"`
    Intersection any `json:"intersection"`
    Discriminator any `json:"discriminator"`
}
