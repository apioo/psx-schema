use serde::{Serialize, Deserialize};
use location::Location;

// An simple author element with some description
#[derive(Serialize, Deserialize)]
pub struct Author {
    #[serde(rename = "title")]
    title: String,

    #[serde(rename = "email")]
    email: Option<String>,

    #[serde(rename = "categories")]
    categories: Option<Vec<String>>,

    #[serde(rename = "locations")]
    locations: Option<Vec<Location>>,

    #[serde(rename = "origin")]
    origin: Option<Location>,

}

