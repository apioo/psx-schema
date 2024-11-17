use serde::{Serialize, Deserialize};
use boolean_property_type::BooleanPropertyType;
use integer_property_type::IntegerPropertyType;
use number_property_type::NumberPropertyType;
use string_property_type::StringPropertyType;
use property_type::PropertyType;

// Base scalar property type
#[derive(Serialize, Deserialize)]
pub struct ScalarPropertyType {
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

}

